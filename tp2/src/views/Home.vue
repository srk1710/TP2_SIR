<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <Publicacao user="Welcome to Your Vue.js App" />
  </div>
</template>

<script>
import router from "../router";
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
    }
  }
};
</script>
