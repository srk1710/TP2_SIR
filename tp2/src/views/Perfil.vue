<template>
  <div style="padding: 50px;">
    <!-- CABECALHO -->
    <v-row style="padding: 10px; width: 100%;">
      <v-col class="col-3">
        <v-img
          v-bind:src="this.foto"
          id="imagemPerfil"
          aspect-ratio="1"
          class="grey lighten-2"
          max-width="140px"
          style="border-radius: 50%; max-width: 100px;"
          align="middle"
        ></v-img>
      </v-col>
      <v-col class="col-3 d-flex align-center mb-6">
        <v-row>
          <h1 class="font-weight-black" style="font-family: Roboto;">240</h1>
        </v-row>
        <v-row>
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Publicações</p>
        </v-row>
      </v-col>
      <v-col class="col-3 d-flex align-center mb-6">
        <v-row>
          <h1 class="font-weight-black" style="font-family: Roboto;">1600</h1>
        </v-row>
        <v-row>
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Seguidores</p>
        </v-row>
      </v-col>
      <v-col class="col-3 d-flex align-center mb-6">
        <v-row>
          <h1 class="font-weight-black" style="font-family: Roboto;">2240</h1>
        </v-row>
        <v-row>
          <p class="font-weight-thin text-center" style="font-family: Roboto;">A seguir</p>
        </v-row>
      </v-col>
    </v-row>
    <v-row style="width: 100%;">
      <div>
        <h3 class="font-weight-black" style="font-family: Roboto;">
          {{username}}
        </h3>
      </div>
    </v-row>
    <v-row style="width: 100%;">
      <div>Sobre {{nome}}: {{bio}}</div>
    </v-row>
  </div>
</template>

<script>
import router from "../router";
import userAtivo from "../store/modules/utilizador";

export default {
  data: () => ({
    username: "",
    nome: "",
    bio: "",
    foto: ""
  }),
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    } else {
      /*var userLogado = this.$store.getters["userAtivo/getLista"];
      this.username = userLogado[0].username;
      this.nome = userLogado[0].nome;
      this.bio = userLogado[0].bio;*/
    }
  },
  mounted: function() {
    var userLogado = this.$store.getters["userAtivo/getLista"];
    this.username = userLogado[0].username;
    this.nome = userLogado[0].nome;
    this.bio = userLogado[0].bio;
    this.foto = userLogado[0].foto;
  }
};
</script>
