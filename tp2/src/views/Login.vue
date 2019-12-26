<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Bem-Vindo</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field label="Email" name="email" prepend-icon="mdi-at" type="text" />
                  <v-text-field
                    id="password"
                    label="Password"
                    name="password"
                    prepend-icon="mdi-lock-question"
                    type="password"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="primary">Entrar</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import router from "../router";
import axios from "axios";
export default {
  name: "Login",
  methods: {
    login: e => {
      e.preventDefault();
      let email = "user@email.com";
      let password = "password";
      let login = () => {
        let data = {
          email: email,
          password: password
        };
        axios
          .get("http://localhost/SIR/TP2_SIR/api/login.php", data)
          .then(response => {
            console.log(response);
            //router.push("/home")
          })
          .catch(errors => {
            console.log(errors);
          });
      };
      login();
    }
  }
};
</script>
