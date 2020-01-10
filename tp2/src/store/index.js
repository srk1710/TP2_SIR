import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import userAtivo from "./modules/utilizador";

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    userAtivo
  }
});
