import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import userAtivo from "./modules/utilizador";
import publicacoes from "./modules/publicacoes";

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    userAtivo,
    publicacoes
  }
});
