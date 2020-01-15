//Dados
const state= {
    data: [
        
    ],
    publicacoes: [

    ]
}

//Retorna-nos algo dos dados
const getters = {
    getLista: (state) => {
        return state.data
    },
    getPublicacoes: (state) => {
        return state.publicacoes
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
    addPub({commit}, params){
        commit('pushPub', params);
    },
    removePub({commit}, key){
        commit('removePub', key);
    },
    clearAll({ commit }) {
        for(var i = state.data.length; i >= 0; i--){
            commit('remove', 0);
        }
        for(var i = state.publicacoes.length; i >= 0; i--){
            commit('removePub', 0);
        }
    }
}

//Altera os dados
const mutations = {
    push(state, params){
        state.data.push(params);
    },
    remove(state, key){
        state.data.splice( key, 1 );
    },
    pushPub(state, params) {
        state.publicacoes.push(params);
    },
    removePub(state, key) {
        state.publicacoes.splice(key, 1);
    }
}

export default{
    state,
    actions,
    getters,
    mutations,
    namespaced: true
}