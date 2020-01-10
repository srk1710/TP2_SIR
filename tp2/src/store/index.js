import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import lista from "./modules/utilizadores";

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    lista
  }
});
