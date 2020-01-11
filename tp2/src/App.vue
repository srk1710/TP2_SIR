<template>
  <div id="app">
    <v-tabs style="position: fixed; z-index: 5000;" v-if="existe">
      <v-tab class="col-3">
        <router-link class="col-12" tag="div" to="/">
          <v-icon left>mdi-home</v-icon>
        </router-link>
      </v-tab>
      <v-tab class="col-3">
        <router-link class="col-12" tag="div" to="/nova">
          <v-icon left>mdi-plus-box</v-icon>
        </router-link>
      </v-tab>
      <v-tab class="col-3">
        <router-link  class="col-12" tag="div" to="/perfil">
          <v-icon left>mdi-account</v-icon>
        </router-link>
      </v-tab>
      <v-tab class="col-3">
        <router-link class="col-12" tag="div" to="/login">
          <v-icon left>mdi-exit-to-app</v-icon>
        </router-link>
      </v-tab>
    </v-tabs>
    <!--<v-app-bar class="d-flex justify-space-around mb-6" v-if="existe" app color="primary" dark>
      <v-card class="pa-2">
        <router-link to="/" class="pa-2">
          <v-icon left>mdi-home</v-icon>
        </router-link>
      </v-card>
      <v-card class="pa-2">
        <router-link to="/nova">
          <v-icon left>mdi-plus-box</v-icon>
        </router-link>
      </v-card>
      <v-card class="pa-2">
        <router-link to="/perfil">
          <v-icon left>mdi-account</v-icon>
        </router-link>
      </v-card>
      <v-card class="pa-2">
        <router-link to="/login">
          <v-icon left>mdi-exit-to-app</v-icon>
        </router-link>
      </v-card>
    </v-app-bar>-->
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
      } else {
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