<template>
  <div id="app">
    <v-app id="inspire" >
        <v-container fluid fill-height>
          <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
              <v-card class="elevation-12">
                <v-toolbar color="primary" dark flat>
                  <v-toolbar-title>Bem-Vindo</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                  <v-form>
                    <v-text-field label="Login" name="login" prepend-icon="mdi-at" type="text"></v-text-field>

                    <v-text-field
                      id="password"
                      label="Password"
                      name="password"
                      prepend-icon="mdi-lock"
                      type="password"
                    ></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary">Login</v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
    </v-app>
  </div>
<!--<div>
    <h2>Login</h2>
    <form v-on:submit="login">
      <input type="text" name="email" />
      <br />
      <input type="password" name="password" />
      <br />
      <input type="submit" value="Login" />
    </form>
  </div>-->
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
          .get("http://localhost:8081/sir/TP2_SIR/api/login.php", data)
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
