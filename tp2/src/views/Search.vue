<template>
  <div style="padding: 50px;">
    <v-row>
      <v-col cols="12">
        <v-text-field v-model="aProcurar" @change="changeProcurar" prepend-icon="mdi-magnify" label="Pesquisa"></v-text-field>
      </v-col>
      {{listaUtilizadores}}
    </v-row>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      aProcurar: null,
      listaUtilizadores: []
    };
  },
  methods: {
    changeProcurar(){
      var user = {
        nome: this.aProcurar,
        id: this.listaUtilizadores.length
      }
      this.listaUtilizadores.push(user);
      const este = this;
      var params = new URLSearchParams();
      params.append("string", this.aProcurar);
      axios({
        method: "POST",
        //url: "http://192.168.64.2/API/api/listaUser.php",
        url: "http://localhost/SIR/TP2_SIR/api/listaUser.php",
        data: params
      })
        .then(function(response) {
          if (!response.data.errors) {
            console.log(response.data);
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
</script>