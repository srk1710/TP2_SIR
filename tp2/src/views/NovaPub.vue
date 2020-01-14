<template>
  <div style="padding: 50px;">
    <v-row>
      <v-col class="col-4"></v-col>
      <v-col class="col-4">
        <v-img style="max-width: 100%" v-bind:src="this.fotoURL"></v-img>
      </v-col>
      <v-col class="col-4"></v-col>
    </v-row>
    <v-row>
      <v-file-input
        chips
        accept="image/png, image/jpeg"
        label="Seleccionar Foto"
        prepend-icon="mdi-camera"
        @change="onSelectFile"
        v-model="ficheiroSelecionado"
      ></v-file-input>
    </v-row>
    <v-row>
      <v-col class="col-2">
        <center>
          <v-img
            style="max-width: 10px;"
            v-bind:src="this.fotoPerfil"
            class="grey lighten-2 perfil"
          ></v-img>
        </center>
      </v-col>
      <v-col class="col-10">
        <v-textarea
          v-model="descricao"
          name="input-4-1"
          label="Descrição"
          hint="Escreve uma legenda"
        ></v-textarea>
      </v-col>
    </v-row>
    <br />
    <center>
      <v-btn @click="submitFiles" x-large text icon color="pink">
        <v-icon>mdi-plus-circle-outline</v-icon>
      </v-btn>
    </center>
  </div>
</template>
<script>
import router from "../router";
import userAtivo from "../store/modules/utilizador";
import axios from "axios";

export default {
  data() {
    return {
      ficheiroSelecionado: null,
      fotoURL: "",
      fotoPerfil: "",
      descricao: ""
    };
  },
  created: function() {
    var existeOnline = this.$store.getters["userAtivo/existe"];
    if (!existeOnline) {
      router.push("/login");
    }
  },
  methods: {
    onSelectFile(event) {
      console.log(event);
      this.fotoURL = URL.createObjectURL(event);
    },
    submitFiles() {
      const este = this;
      var formData = new FormData();
      if (this.ficheiroSelecionado) {
        formData.append("foto", this.ficheiroSelecionado);
        formData.append(
          "user",
          this.$store.getters["userAtivo/getLista"][0].id
        );
        formData.append("descricao", this.descricao);
        axios({
          method: "POST",
          //url: "http://192.168.64.2/api/novaPub.php",
          url: "http://localhost/SIR/TP2_SIR/api/novaPub.php",
          data: formData
        })
          .then(function(response) {
            console.log(response);
            este.$store.dispatch("publicacoesUser/add", {
              foto: response.data.imagem,
              descricao: este.descricao
            });
            router.push("/perfil");
          })
          .catch(function(error) {
            console.log(error);
          });
      } else {
        console.log("Não seleccionou nenhum ficheiro...");
      }
    }
  },
  mounted: function() {
    var userLogado = this.$store.getters["userAtivo/getLista"];
    this.fotoPerfil = userLogado[0].foto;
  }
};
</script>
<style>
.perfil {
  border-radius: 50%;
  max-width: 60% !important;
}
</style>