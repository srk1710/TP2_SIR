<template>
  <div style="padding: 50px;">
    <!-- CABECALHO -->
    <v-row style="width: 100%;">
      <v-col class="col-2">
        <v-img
          v-bind:src="this.foto"
          id="imagemPerfil"
          class="grey lighten-2 perfil"
        ></v-img>
      </v-col>
      <v-col class="col-1"></v-col>
      <v-col class="col-3 d-flex align-center mb-6" style="margin-top: 50px;">
        <v-row>
          <h1 class="font-weight-black" style="font-family: Roboto;">240</h1>
        </v-row>
        <v-row>
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Publicações</p>
        </v-row>
      </v-col>
      <v-col class="col-3 d-flex align-center mb-6" style="margin-top: 50px;">
        <v-row>
          <h1 class="font-weight-black" style="font-family: Roboto;">1600</h1>
        </v-row>
        <v-row>
          <p class="font-weight-thin text-center" style="font-family: Roboto;">Seguidores</p>
        </v-row>
      </v-col>
      <v-col class="col-3 d-flex align-center mb-6" style="margin-top: 50px;">
        <v-row>
          <h1 class="font-weight-black" style="font-family: Roboto;">2240</h1>
        </v-row>
        <v-row>
          <p class="font-weight-thin text-center" style="font-family: Roboto;">A seguir</p>
        </v-row>
      </v-col>
    </v-row>
    <v-row style="margin-top: 20px; padding: 0px 20px; width: 100%;">
      <div>
        <h3 class="font-weight-black" style="font-family: Roboto;">{{username}}</h3>
      </div>
    </v-row>
    <v-row style="padding-left: 20px; width: 100%;">
      <div>Sobre {{nome}}: {{bio}}</div>
    </v-row>
    <!-- PUBLICAÇÕES -->
    <v-row>
      <v-col class="col-4 pub">
        <v-img
          class="publicacoes"
          src="https://abrilsuperinteressante.files.wordpress.com/2019/06/site_temponatureza.png"
        ></v-img>
      </v-col>
      <v-col class="col-4 pub">
        <v-img
          class="publicacoes"
          src="https://www.revistaplaneta.com.br/wp-content/uploads/sites/3/2018/06/12_pl540_unesco1.jpg"
        ></v-img>
      </v-col>
      <v-col class="col-4 pub">
        <v-img
          class="publicacoes"
          src="https://br.jetss.com/wp-content/uploads/2018/05/010130171208-o-que-significa-natureza.jpg"
        ></v-img>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="col-4 pub">
        <v-img
          class="publicacoes"
          src="https://static.mundoeducacao.bol.uol.com.br/mundoeducacao/conteudo_legenda/4235a7c906ca07412869075b58ac3466.jpg"
        ></v-img>
      </v-col>
      <v-col class="col-4 pub">
        <v-img
          class="publicacoes"
          src="https://www.a12.com/source/files/originals/natureza-260802.jpg"
        ></v-img>
      </v-col>
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
<style>
.publicacoes {
  width: 100%;
  height: 300px;
}
.pub {
  padding: 20px;
}
.perfil {
  border-radius: 50%;
  min-width: 100%;
}
</style>