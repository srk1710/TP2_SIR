<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <Publicacao user="Welcome to Your Vue.js App" />
  </div>
</template>

<script>
import router from "../router";
import axios from "axios";
import Publicacao from "@/components/Publicacao.vue";

export default {
  name: "home",
  components: {
    Publicacao
  },
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    }else{
      this.importarPublicacoes();
    }
  },
  methods: {
    importarPublicacoes: function() {
      const este = this;
      var params = new URLSearchParams();
      axios({
        method: "GET",
        url: "http://localhost/SIR/TP2_SIR/api/publicacoes.php"
      })
        .then(function(response) {
          if (!response.data.errors) {
            console.log(response.data.result[0]);
            este.$store.dispatch("publicacoes/add", {
              user: response.data.result[0]["id_user"],
              data: response.data.result[0]["data_publicacao"],
              foto: response.data.result[0]["foto"],
              descricao: response.data.result[0]["descricao"]
            });
            console.log(este.$store.getters["publicacoes/getLista"]);
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
