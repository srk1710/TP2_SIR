<template>
  <div style="padding: 50px;">
    <!-- CABECALHO -->
    <v-row style="width: 100%;">
      <v-col class="col-2">
        <v-img v-bind:src="this.foto" id="imagemPerfil" class="grey lighten-2 perfil"></v-img>
      </v-col>
      <v-col class="col-1"></v-col>
      <v-col style="margin-top: 50px;">
        <v-row class="d-flex justify-center mb-6">
          <h1 class="font-weight-black" style="font-family: Roboto;">{{ this.publicacoes }}</h1>
        </v-row>
        <v-row class="d-flex justify-center mb-6">
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Publicações</p>
        </v-row>
      </v-col>
      <v-col style="margin-top: 50px;">
        <v-row class="d-flex justify-center mb-6">
          <h1 class="font-weight-black" style="font-family: Roboto;">{{this.seguidores}}</h1>
        </v-row>
        <v-row class="d-flex justify-center mb-6">
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Seguidores</p>
        </v-row>
      </v-col>
      <v-col style="margin-top: 50px;">
        <v-row class="d-flex justify-center mb-6">
          <h1 class="font-weight-black" style="font-family: Roboto;">{{this.aSeguir}}</h1>
        </v-row>
        <v-row class="d-flex justify-center mb-6">
          <p class="font-weight-thin text-center" style="font-family: Roboto;">A seguir</p>
        </v-row>
      </v-col>
    </v-row>
    <v-row class="d-flex justify-center mb-6">
      <v-btn large :color="this.seguirColor" @click="seguir()">{{this.seguirBTN}}</v-btn>
    </v-row>
    <v-row style="margin-top: 20px; padding: 0px 20px; width: 100%;">
      <div>
        <h3 class="font-weight-black" style="font-family: Roboto;">{{username}}</h3>
      </div>
    </v-row>
    <v-row style="padding-left: 20px; width: 100%;">
      <div>Sobre {{nome}}: {{bio}}</div>
    </v-row>
    <!-- PUBLICAÇÕES -->
    <v-row>
      <router-link
        v-for="(pub, index) in getPublicacoesUser"
        :key="index"
        :to="{ name: 'pub', params: {ID: pub.id } }"
        class="col-md-4 pub"
      >
        <!--<v-img class="publicacoes" :src="'http://192.168.64.2/API/fotos/' + pub.foto"></v-img>-->
        <v-img class="publicacoes" :src="'http://localhost/SIR/TP2_SIR/fotos/' + pub.foto"></v-img>
      </router-link>
    </v-row>
  </div>
</template>

<script>
import router from "../router";
import axios from "axios";
import userAtivo from "../store/modules/utilizador";

export default {
  props: {
    ID: {
      type: String,
      default: null,
      required: true
    }
  },
  data: () => ({
    username: "",
    nome: "",
    bio: "",
    idUser: "",
    foto: "",
    publicacoes: "",
    intCache: false,
    seguirBTN: "Seguir",
    seguirColor: "primary",
    seguidores: "",
    aSeguir: ""
  }),
  computed: {
    getPublicacoesUser() {
      return this.$store.getters["userCache/getPublicacoes"];
    }
  },
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    } else if (this.ID === this.$store.getters["userAtivo/getLista"][0].id) {
      router.push("/perfil");
    }
  },
  mounted: function() {
    const este = this;

    this.$store.dispatch("userCache/clearAll");

    if (!this.intCache) {
      var params = new URLSearchParams();
      params.append("idUser", this.ID);
      params.append(
        "idLogado",
        this.$store.getters["userAtivo/getLista"][0].id
      );
      axios({
        method: "POST",
        //url: "http://192.168.64.2/API/api/userCache.php",
        url: "http://localhost/SIR/TP2_SIR/api/userCache.php",
        data: params
      })
        .then(function(response) {
          if (!response.data.errors) {
            este.intCache = true;

            este.$store.dispatch("userCache/add", {
              username: response.data.result[0]["username"],
              nome: response.data.result[0]["nome"],
              bio: response.data.result[0]["bio"],
              foto: response.data.result[0]["fotoUser"],
              publicacoes: response.data.result[0]["count"],
              segue: response.data.result[0]["segue"],
              id: response.data.result[0]["idUser"]
            });

            este.username = response.data.result[0]["username"];
            este.nome = response.data.result[0]["nome"];
            este.bio = response.data.result[0]["bio"];
            este.foto = response.data.result[0]["fotoUser"];
            este.publicacoes = response.data.result[0]["count"];
            este.seguidores = response.data.result[0]["seguidores"];
            este.aSeguir = response.data.result[0]["aSeguir"];
            este.idUser = response.data.result[0]["idUser"];
            if (response.data.result[0]["segue"]) {
              este.seguirBTN = "A seguir";
              este.seguirColor = "";
            }

            var tamanho = response.data.result.length;

            for (var i = tamanho - 1; i >= 0; i--) {
              este.$store.dispatch("userCache/addPub", {
                id: response.data.result[i]["idPub"],
                foto: response.data.result[i]["fotoPub"],
                descricao: response.data.result[i]["descricao"],
                data: response.data.result[i]["data_publicacao"]
              });
            }
          } else {
            console.log(response.data);
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  methods: {
    seguir() {

      const este = this;

      var params = new URLSearchParams();

      if (this.seguirBTN === "Seguir") {
        params.append("seguir", "true");
      } else {
        params.append("seguir", "false");
      }
      params.append("idSegue", this.$store.getters["userAtivo/getLista"][0].id);
      params.append("idSeguido", this.idUser);

      axios({
        method: "POST",
        // url: "http://192.168.64.2/API/api/seguirUser.php",
        url: "http://localhost/SIR/TP2_SIR/api/seguirUser.php",
        data: params
      })
        .then(function(response) {
          if (!response.data.errors) {
            if (este.seguirBTN === "Seguir") {
              este.seguirBTN = "A Seguir";
              este.seguirColor = "";
            } else {
              este.seguirBTN = "Seguir";
              este.seguirColor = "primary";
            }
          } else {
            console.log(response.data);
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>
<style>
.publicacoes {
  height: 100%;
}
router-link {
  width: 100%;
  padding: 10px;
}
router-link:hover {
  opacity: 0.5;
  cursor: pointer;
}
.perfil {
  border-radius: 50%;
  min-width: 100%;
}
</style>