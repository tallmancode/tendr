export default {
    namespaced: true,

    state: {
        company: null
    },

    getters: {

    },

    mutations: {
        SET_COMPANY(state, value) {
            state.company = value
        }
    },

    actions: {
        getCompany({commit}, companyId){
            axios
            .get('/api/company/'+companyId)
            .then((resp) => {
                commit('SET_COMPANY', resp.data)
            })
        }
    }
}


