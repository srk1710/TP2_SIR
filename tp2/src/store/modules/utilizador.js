//Dados
const state= {
    data: []
}

//Retorna-nos algo dos dados
const getters = {
    getLista: (state) => {
        return state.data
    },
    existe: (state) => {
        return state.data.length;
    }
}

//Action ativa a mutation - em regra
const actions = {
    add({commit}, params){
        commit('push', params);
    },
    remove({commit}, key){
        commit('remove', key);
    },
    set({commit}, params){
        commit('set', params);
    }
}

//Altera os dados
const mutations = {
    push(state, params){
        state.data.push(params);
    },
    remove(state, key){
        state.data.splice( key, 1);
    },
    set(state, params){
        state.data[0] = params;
    }
}

export default{
    state,
    actions,
    getters,
    mutations,
    namespaced: true
}