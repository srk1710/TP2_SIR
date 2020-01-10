<template>
  <div id="app">
    <v-app-bar v-if="existe" app color="primary" dark>
      <router-link to="/">
        <v-btn class="ma-2" title outlined color="white">
          <v-icon left>mdi-home</v-icon>Home
        </v-btn>
      </router-link>
      <router-link to="/login">
        <v-btn class="ma-2" title outlined color="white">
          <v-icon left>mdi-settings</v-icon>
          {{ textLogin }}
        </v-btn>
      </router-link>
    </v-app-bar>
    <v-content>
      <v-container fluid fill-heigth>
        <router-view></router-view>
      </v-container>
    </v-content>
  </div>
</template>

<script>
export default {
  name: "App",

  data: () => ({
    textLogin: "Login"
  }),
  computed: {
    existe() {
      var existeOnline = this.$store.getters["userAtivo/existe"];
      if (existeOnline) {
        return true;
      }else{
          return false;
      }
    }
  }
};
</script>

<style>
body {
  background-color: #f0f0f0;
}
h1 {
  padding: 0;
  margin-top: 0;
}
#app {
  width: 100%;
  margin: auto;
}
</style>