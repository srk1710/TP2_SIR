<template>
  <div style="padding: 50px;">
    <v-row>
      <v-col cols="12">
        <v-text-field
          v-model="aProcurar"
          @input="changeProcurar"
          prepend-icon="mdi-magnify"
          label="Pesquisa"
        ></v-text-field>
      </v-col>
    </v-row>
    <router-link
      v-for="(user, index) in listaUtilizadores"
      :key="index"
      class="row linhaSearch"
      tag="v-row"
      :to="{ name: 'perfilGeral', params: {ID: user.id } }"
    >
      <table>
        <tr>
          <td rowspan="2">
            <v-img
              v-bind:src="user.foto"
              class="grey lighten-2"
              max-width="60px"
              style="border-radius: 50%"
              align="middle"
            ></v-img>
          </td>
          <td>
            <h2>{{user.username}}</h2>
          </td>
        </tr>
        <tr>
          <td>
            <i>{{user.nome}}</i>
          </td>
        </tr>
      </table>
    </router-link>
  </div>
</template>
<script>
import axios from "axios";
import router from "../router";

export default {
  data() {
    return {
      aProcurar: null,
      listaUtilizadores: []
    };
  },
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    }
  },
  methods: {
    changeProcurar() {

      const este = this;

      este.listaUtilizadores = [];

      var params = new URLSearchParams();
      params.append("string", this.aProcurar);
      if (this.aProcurar !== "") {
        axios({
          method: "POST",
          url: "http://192.168.64.2/API/api/listaUser.php",
          // url: "http://localhost/SIR/TP2_SIR/api/listaUser.php",
          data: params
        })
          .then(function(response) {
            if (!response.data.errors) {
              var tamanho = response.data.result.length;
              var userTMP = {};

              este.listaUtilizadores = [];

              for (var i = 0; i < tamanho; i++) {
                userTMP = {};
                userTMP.nome = response.data.result[i].nome;
                userTMP.username = response.data.result[i].username;
                userTMP.id = response.data.result[i].id;
                userTMP.foto = response.data.result[i].foto;
                if (este.listaUtilizadores.indexOf(userTMP) < 0) {
                  este.listaUtilizadores.push(userTMP);
                }
              }
            } else {
              console.log(response.data.message);
            }
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    }
  }
};
</script>
<style>
.linhaSearch:hover {
  cursor: pointer;
  background: whitesmoke;
}
</style>