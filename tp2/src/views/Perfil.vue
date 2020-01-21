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
          <h1 class="font-weight-black" style="font-family: Roboto;">1600</h1>
        </v-row>
        <v-row class="d-flex justify-center mb-6">
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Seguidores</p>
        </v-row>
      </v-col>
      <v-col style="margin-top: 50px;">
        <v-row class="d-flex justify-center mb-6">
          <h1 class="font-weight-black" style="font-family: Roboto;">2240</h1>
        </v-row>
        <v-row class="d-flex justify-center mb-6">
          <p class="font-weight-thin text-center" style="font-family: Roboto;">A seguir</p>
        </v-row>
      </v-col>
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
      <router-link v-for="(pub, index) in getPublicacoesUser" :key="index" :to="{ name: 'pub', params: {ID: pub.id } }" class="col-md-4 pubPerfil">
        <!-- <v-img class="publicacoes" :src="'http://192.168.64.2/API/fotos/' + pub.foto"></v-img>-->
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
  data: () => ({
    username: "",
    nome: "",
    bio: "",
    foto: "",
    publicacoes: ""
  }),
  computed: {
    getPublicacoesUser() {
      return this.$store.getters["publicacoesUser/getLista"];
    }
  },
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    }
  },
  mounted: function() {
    const este = this;
    
    var userLogado = this.$store.getters["userAtivo/getLista"];
    this.username = userLogado[0].username;
    this.nome = userLogado[0].nome;
    this.bio = userLogado[0].bio;
    this.foto = userLogado[0].foto;
    this.publicacoes = userLogado[0].publicacoes;

    if (!este.$store.getters["publicacoesUser/existe"]) {
      var params = new URLSearchParams();
      params.append("idUser", userLogado[0].id);
      axios({
        method: "POST",
        //url: "http://192.168.64.2/API/api/publicacoesUser.php",
        url: "http://localhost/SIR/TP2_SIR/api/publicacoesUser.php",
        data: params
      })
        .then(function(response) {
          if (!response.data.errors) {
            var tamanho = response.data.result.length;
            for (var i = tamanho - 1; i >= 0; i--) {
              este.$store.dispatch("publicacoesUser/add", {
                id: response.data.result[i]["id"],
                foto: response.data.result[i]["foto"],
                descricao: response.data.result[i]["descricao"],
                data: response.data.result[i]["data"]
              });
            }
            //console.log(este.$store.getters["publicacoesUser/getLista"]);
          } else {
            alert(response.data.message);
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
.pubPerfil {
  width: 100%;
  padding: 10px;
}
.pubPerfil:hover{
  opacity: 0.5;
  cursor: pointer;
}
.perfil {
  border-radius: 50%;
  min-width: 100%;
}
</style>