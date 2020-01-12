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
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="validar()">Login</v-btn>
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
        url: "http://192.168.64.2/api/login.php",
        data: params
      })
        .then(function(response) {
          if (!response.data.errors) {
            console.log(response.data.result[0]);
            este.$store.dispatch("userAtivo/add", {
              username: response.data.result[0]["username"],
              nome: response.data.result[0]["nome"],
              email: response.data.result[0]["email"],
              data_nasc: response.data.result[0]["data_nasc"],
              foto: response.data.result[0]["foto"],
              bio: response.data.result[0]["bio"]
            });
            router.push("/");
          } else {
            alert(response.data.message);
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>
