<template>
  <div id="app">
    <v-app id="inspire">
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Bem-Vindo</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field label="User" v-model="user" prepend-icon="mdi-at" type="text"></v-text-field>
                  <v-text-field
                    label="Password"
                    v-model="password"
                    prepend-icon="mdi-lock"
                    type="password"
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn color="primary" @click="registar()">Registar</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="validar()">Entrar</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-app>
  </div>
</template>

<script>
import router from "../router";
import axios from "axios";
import userAtivo from "../store/modules/utilizador";

export default {
  data: () => ({
    user: "",
    password: ""
  }),
  methods: {
    validar() {
      const este = this;
      var params = new URLSearchParams();
      params.append("username", this.user);
      params.append("password", this.password);
      axios({
        method: "POST",
        //url: "http://192.168.64.2/API/api/login.php",
        url: "http://localhost/SIR/TP2_SIR/api/login.php",
        data: params
      })
        .then(function(response) {
          if (!response.data.errors) {
            
            //console.log(response.data.result[0]);
            
            este.$store.dispatch("userAtivo/add", {
              username: response.data.result[0]["username"],
              id: response.data.result[0]["id"],
              nome: response.data.result[0]["nome"],
              email: response.data.result[0]["email"],
              data_nasc: response.data.result[0]["data_nasc"],
              foto: response.data.result[0]["foto"],
              bio: response.data.result[0]["bio"],
              publicacoes: response.data.result[0]["count"],
              seguidores: response.data.result[0]["seguidores"],
              aSeguir: response.data.result[0]["aSeguir"]
            });
            router.push("/");
          } else {
            alert(response.data.message);
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    registar(){
        router.push("/registar");
    }
  },
  mounted: function() {
    this.$store.dispatch("userAtivo/remove", 0);
    this.$store.dispatch("publicacoesUser/clearAll");
    this.sizeProgress = 0;
  }
};
</script>
