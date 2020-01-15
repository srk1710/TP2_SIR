<template>
  <div class="home" id="home">
    <div
      v-for="(pub, index) in getPublicacoes"
      :key="index"
      class="col-md-12 pubHome"
    >
      <Publicacao
        :idUser="pub.idUser"
        :idPub="pub.idPub"
        :username="pub.username"
        :nomeUser="pub.nomeUser"
        :data="pub.data"
        :descricao="pub.descricao"
        :fotoUser="pub.fotoUser"
        :fotoPub="pub.fotoPub"
      />
    </div>
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
    } else {
      //this.importarPublicacoes();
    }
  },
  computed: {
    getPublicacoes() {
      return this.$store.getters["publicacoes/getLista"];
    }
  },
  mounted: function() {
    var home = document.getElementById("home");
    const este = this;
    var params = new URLSearchParams();
    axios({
      method: "GET",
      //url: "http://192.168.64.2/api/publicacoes.php",
      url: "http://localhost/SIR/TP2_SIR/api/publicacoes.php"
    })
      .then(function(response) {
        if (!response.data.errors) {
          este.$store.dispatch("publicacoes/clearAll");
          console.log(response.data.result);
          var conteudo = "";
          for (var i = 0; i < response.data.result.length; i++) {
            este.$store.dispatch("publicacoes/add", {
              idUser: response.data.result[i]["idUser"],
              idPub: response.data.result[i]["idPub"],
              username: response.data.result[i]["username"],
              nomeUser: response.data.result[i]["nomeUser"],
              data: response.data.result[i]["data"],
              descricao: response.data.result[i]["descricao"],
              fotoUser: response.data.result[i]["fotoUser"],
              fotoPub: response.data.result[i]["fotoPub"]
            });
          }
        } else {
          alert(response.data.message);
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
</script>
<style>
.pubHome {
  width: 100%;
  padding: 10px;
}
.pubHome:hover{
  cursor: pointer;
  opacity: 0.8;
}
</style>