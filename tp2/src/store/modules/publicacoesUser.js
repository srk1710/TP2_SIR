//Dados
const state = {
    data: []
}

//Retorna-nos algo dos dados
const getters = {
    getLista: (state) => {
        return state.data
    },
    existe: (state) => {
        if(state.data.length > 0){
            return true;
        }else{
            return false;
        }
    }
}


//Action ativa a mutation - em regra
const actions = {
    add({ commit }, params) {
        commit('push', params);
    },
    remove({ commit }, key) {
        commit('remove', key);
    },
    clearAll({ commit }) {
        for(var i = state.data.length; i >= 0; i--){
            commit('remove', 0);
        }
    }
}

//Altera os dados
const mutations = {
    push(state, params) {
        state.data.push(params);
    },
    remove(state, key) {
        state.data.splice(key, 1);
    }
}

export default {
    state,
    actions,
    getters,
    mutations,
    namespaced: true
}