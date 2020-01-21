<template>
  <div id="app">
    <v-app id="inspire">
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Registo</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    label="Nome de Utilizador"
                    v-model="user"
                    prepend-icon="mdi-account"
                    type="text"
                    :rules="formRules"
                    required
                    @change="verificaNome"
                  ></v-text-field>
                  <v-text-field
                    label="Nome"
                    v-model="nome"
                    prepend-icon="mdi-account-box"
                    type="text"
                    :rules="formRules"
                    required
                  ></v-text-field>
                  <v-text-field
                    label="Email"
                    v-model="email"
                    prepend-icon="mdi-at"
                    type="text"
                    :rules="formRules"
                    required
                  ></v-text-field>
                  <v-dialog
                    ref="dialog"
                    v-model="modal"
                    :return-value.sync="date"
                    persistent
                    :rules="formRules"
                    required
                    width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="date"
                        label="Data de Nascimento"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="date" autocomplete="off" scrollable>
                      <v-btn text color="primary" @click="modal = false">Cancel</v-btn>
                      <v-btn text color="primary" @click="$refs.dialog.save(date)">OK</v-btn>
                    </v-date-picker>
                  </v-dialog>
                  <v-text-field
                    label="Password"
                    v-model="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    :rules="formRules"
                    required
                  ></v-text-field>
                  <v-text-field
                    label="Confirme a Password"
                    v-model="password1"
                    prepend-icon="mdi-lock"
                    type="password"
                    :rules="formRules"
                    required
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn color="primary" @click="retroceder()">Retroceder</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="validarRegisto()">Registar</v-btn>
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
    date: new Date().toISOString().substr(0, 10),
    valid: true,
    menu: false,
    modal: false,
    menu2: false,
    nome: "",
    email: "",
    date: "",
    user: "",
    password: "",
    password1: "",
    listaUsers: [],
    formRules: [v => !!v || "Campo Obrigatório"]
  }),
  methods: {
    verificaNome() {
      for (var i = 0; i < this.listaUsers.length; i++) {
        if (this.user === this.listaUsers[i]) {
          alert("Nome de Utilizador já existe");
          this.user = "";
        }
      }
    },
    validarRegisto() {
      if (
        this.user &&
        this.email &&
        this.date &&
        this.nome &&
        this.password &&
        this.password1
      ) {
        if (this.password === this.password1) {
          const este = this;
          var params = new URLSearchParams();
          params.append("user", this.user);
          params.append("email", this.email);
          params.append("date", this.date);
          params.append("nome", this.nome);
          params.append("password", this.password);

          axios({
            method: "POST",
            url: "http://192.168.64.2/API/api/createUser.php",
            // url: "http://localhost/SIR/TP2_SIR/api/createUser.php",
            data: params
          })
            .then(function(response) {
               console.log(response);
               if(response.data.errors){
                   console.log(response.data.message);
               }
               else{
                   router.push("/login");
               }
            })
            .catch(function(error) {
              console.log(error);
            });
        } else {
          alert("Passwords não coincidem.");
          this.password = "";
          this.password1 = "";
        }
      }
    },
    retroceder() {
      router.push("/login");
    }
  },
  created: function() {
    const este = this;

    var params = new URLSearchParams();
    params.append("string", "");
    axios({
      method: "POST",
      url: "http://192.168.64.2/API/api/listaUser.php",
      // url: "http://localhost/SIR/TP2_SIR/api/listaUser.php",
      data: params
    })
      .then(function(response) {
        if (response.data.error) {
          console.log(response.data.message);
        } else {
          for (var i = 0; i < response.data.result.length; i++) {
            este.listaUsers.push(response.data.result[i].username);
          }
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};
</script>
