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
                  <v-text-field label="Login" v-model="login" prepend-icon="mdi-at" type="text"></v-text-field>
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
                <v-btn color="primary" @click="login">Login</v-btn>
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
    login: "",
    password: "",
    user: []
  }),
  computed: {
    getUser() {
      return this.$store.getters["utilizadores/getLista"];
    }
  },
  methods: {
    login() {
      console.log(user);
    }
  }
};
</script>
