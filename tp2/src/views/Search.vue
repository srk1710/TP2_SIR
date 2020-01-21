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
    <v-row v-for="(pub, index) in getPublicacoes" :key="index" class="col-md-12">
      {{listaUtilizadores}}
    </v-row>
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
      this.listaUtilizadores = [];

      const este = this;
      var params = new URLSearchParams();
      params.append("string", this.aProcurar);
      if (this.aProcurar !== "") {
        axios({
          method: "POST",
          //url: "http://192.168.64.2/API/api/listaUser.php",
          url: "http://localhost/SIR/TP2_SIR/api/listaUser.php",
          data: params
        })
          .then(function(response) {
            if (!response.data.errors) {
              var tamanho = response.data.result.length;
              for (var i = 0; i < tamanho; i++) {
                var user = {};
                user.nome = response.data.result[i].nome;
                user.id = response.data.result[i].id;
                user.foto = response.data.result[i].foto;
                este.listaUtilizadores.push(user);
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