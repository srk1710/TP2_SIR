<template>
  <div style="padding: 50px;">
    <!-- CABECALHO -->
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
        <h2 class="font-weight-black" style="font-family: Roboto;">{{ this.username }}</h2>
        <p class="font-weight-thin text-center" style="font-family: Roboto;">{{ this.nomeUser }}</p>
      </div>
    </v-row>
    <!-- FOTO -->
    <v-row>
      <v-col class="col-md-6">
        <v-img
          v-bind:src="'http://localhost/SIR/TP2_SIR/fotos/' + this.fotoPub"
          aspect-ratio="1"
          class="grey lighten-2"
          width="100%"
        ></v-img>
      </v-col>
    </v-row>
    <v-row style="margin-left: 20px;">
      <p class="font-weight-black" style="font-family: Roboto;">
        <b>{{ this.username }}</b>
        {{ this.descricao }}
      </p>
    </v-row>
    <!-- COMENTARIOS -->
    <v-row></v-row>
    <!-- DATA -->
    <v-row>
      <i style="font-family: Roboto; margin: 15px 20px 30px 20px; color: grey">{{this.data}}</i>
    </v-row>
  </div>
</template>
<script>
export default {
  props: {
    idUser: String,
    nomeUser: String,
    idPub: String,
    username: String,
    fotoUser: String,
    fotoPub: String,
    descricao: String,
    data: String
  }
}
</script>