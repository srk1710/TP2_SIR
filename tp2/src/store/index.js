import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import userAtivo from "./modules/utilizador";
import publicacoes from "./modules/publicacoes";
import publicacoesUser from "./modules/publicacoesUser";

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    userAtivo,
    publicacoes,
    publicacoesUser
  }
});
