<template>
  <div style="padding: 50px;">
    <!-- CABECALHO -->
    <v-row style="padding: 10px;">
      <v-img
        v-bind:src="this.fotoUser"
        aspect-ratio="1"
        class="grey lighten-2"
        max-width="70px"
        style="border-radius: 50%"
        align="middle"
      ></v-img>
      <div style="margin-left: 50px;">
        <h1 class="font-weight-black" style="font-family: Roboto;">{{ this.user }}</h1>
        <p class="font-weight-thin text-center" style="font-family: Roboto;">{{ this.nomeUser }}</p>
      </div>
    </v-row>
    <!-- FOTO -->
    <v-row>
      <v-col class="col-md-6">
        <!-- <v-img
           v-bind:src="'http://localhost/SIR/TP2_SIR/fotos/' + this.fotoPub"  
          aspect-ratio="1"
          class="grey lighten-2"
          width="100%"
        ></v-img> -->

        <v-img
           v-bind:src="'http://192.168.64.2/API/fotos/' + this.fotoPub"  
          aspect-ratio="1"
          class="grey lighten-2"
          width="100%"
        ></v-img>
      </v-col>
    </v-row>
    <v-row style="margin-left: 20px;">
      <p class="font-weight-black" style="font-family: Roboto;">
        <b>{{ this.user }}</b>
        {{ this.descricao }}
      </p>
    </v-row>
    <!-- COMENTARIOS -->
    <v-row>
      <p
        v-for="(com, index) in getComentarios"
        :key="index"
        class="font-weight-black"
        style="font-family: Roboto;"
      >
        <b>{{ com.username }}</b>
        {{ com.conteudo }}ssss
      </p>
      <p
        class="font-weight-black perfil"
        style="font-family: Roboto; margin-left: 40px;"
        id="comentarios"
      ></p>
    </v-row>
    <v-row>
      <v-text-field v-model="novoComentario"></v-text-field>
      <v-btn @click="submitComent" x-large text icon color="pink">
        <v-icon>mdi-plus-circle-outline</v-icon>
      </v-btn>
    </v-row>
    <v-row>
      <i style="font-family: Roboto; margin-left: 20px; color: grey">{{this.data}}</i>
    </v-row>
  </div>
</template>

<script>
import router from "../router";
import axios from "axios";

export default {
  props: {
    ID: {
      type: Number,
      default: null,
      required: true
    }
  },
  data: () => ({
    fotoPub: "",
    descricao: "",
    fotoUser: "",
    user: "",
    nomeUser: "",
    idUser: "",
    data: "",
    novoComentario: ""
  }),
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    } else {
    }
  },
  methods: {
    submitComent() {
      var comentarioP = document.getElementById("comentarios");

      const este = this;
      var params = new URLSearchParams();
      params.append("idUser", this.$store.getters["userAtivo/getLista"][0].id);
      params.append("idPub", this.ID);
      params.append("conteudo", this.novoComentario);
      axios({
        method: "POST",
        // url: "http://192.168.64.2/API/api/novoComent.php",
        url: "http://localhost/SIR/TP2_SIR/api/novoComent.php",
        data: params
      })
        .then(function(response) {
          console.log(response);
          var conteudo = "";
          conteudo +=
            "<br><b>" +
            este.$store.getters["userAtivo/getLista"][0].username +
            "</b>";
          conteudo += " ";
          conteudo += este.novoComentario;
          comentarioP.innerHTML += conteudo;
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted: function() {
    const este = this;
    var params = new URLSearchParams();
    params.append("idPub", this.ID);
    axios({
      method: "POST",
      // url: "http://192.168.64.2/API/api/publicacao.php",
     url: "http://localhost/SIR/TP2_SIR/api/publicacao.php",
      data: params
    })
      .then(function(response) {
        if (!response.data.errors) {

          //console.log(response.data);

          este.fotoPub = response.data.result[0].fotoPub;
          este.fotoUser = response.data.result[0].fotoUser;
          este.user = response.data.result[0].username;
          este.nomeUser = response.data.result[0].nome;
          este.idUser = response.data.result[0].idUser;
          este.descricao = response.data.result[0].descricao;
          este.data = response.data.result[0].data_publicacao;
          var data = response.data.result[0].data_publicacao.split("-");
          var ultimaData = data[2].split(" ");
          var meses = [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
          ];
          var mesInt = parseInt(data[1]);
          este.data =
            ultimaData[0] + " de " + meses[mesInt - 1] + " de " + data[0];
        } else {
          console.log(response.data.message);
        }
      })
      .catch(function(error) {
        console.log(error);
      });

    var comentarioP = document.getElementById("comentarios");

    var params = new URLSearchParams();
    params.append("idPub", this.ID);
    axios({
      method: "POST",
      // url: "http://192.168.64.2/API/api/comentarios.php",
      url: "http://localhost/SIR/TP2_SIR/api/comentarios.php",
      data: params
    })
      .then(function(response) {
        if (!response.data.errors) {

          //console.log(response.data.result);

          var conteudo = "";
          for (var i = 0; i < response.data.result.length; i++) {
            conteudo += "<br><b>" + response.data.result[i].username + "</b>";
            conteudo += " ";
            conteudo += response.data.result[i].conteudo;
          }
          comentarioP.innerHTML = conteudo;
          
        } else {
          console.log(response.data.message);
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
</script>