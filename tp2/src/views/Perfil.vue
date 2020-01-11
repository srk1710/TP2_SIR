<template>
  <div style="padding: 50px;">
    <!-- CABECALHO -->
    <v-row style="padding: 10px; width: 100%;">
      <v-col class="col-3">
        <v-img
          src="https://picsum.photos/id/11/500/300"
          lazy-src="https://picsum.photos/id/11/10/6"
          aspect-ratio="1"
          class="grey lighten-2"
          max-width="140px"
          style="border-radius: 50%"
          align="middle"
        ></v-img>
      </v-col>
      <v-col class="col-3">
        <v-row>
          <h3>240</h3>
        </v-row>
        <v-row>Publicações</v-row>
      </v-col>
      <v-col class="col-3">
        <v-row>
          <h3>1620</h3>
        </v-row>
        <v-row>Seguidores</v-row>
      </v-col>
      <v-col class="col-3">
        <v-row>
          <h3>2061</h3>
        </v-row>
        <v-row>A seguir</v-row>
      </v-col>
    </v-row>
    <v-row style="width: 100%;">
      <div>Nome de Utilizador</div>
    </v-row>
    <v-row style="width: 100%;">
      <div>Bio</div>
    </v-row>
  </div>
</template>
