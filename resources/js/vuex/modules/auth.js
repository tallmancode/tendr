export default {
    namespaced: true,

    state: {
        authenticated: false,
        user: null
    },

    getters: {
        authenticated(state) {
            return state.authenticated
        },

        user(state) {
            return state.user
        },
    },

    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },

        SET_USER(state, value) {
            state.user = value
        }
    },

    actions: {
        async signIn({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login', credentials)
            return dispatch('me')
        },

        async logOut({ commit }) {
            await axios
                    .post('/logout')
                    .then((resp) => {
                        if(resp.status === 204){
                            commit('SET_AUTHENTICATED', false)
                            commit('SET_USER', null)
                            location.reload();
                        }
                        console.log(resp)
                    })
        },

        async me({ commit }) {
            await axios.get('/sanctum/csrf-cookie')
            return axios.get('/api/user').then((response) => {
                Vue.$snitch.log({message: 'auth/me', groups: ['auth'], info: false})
                Vue.$snitch.log({message: response, groups: ['auth'] })
                commit('SET_AUTHENTICATED', true)
                commit('SET_USER', response.data)
                return response.data
            }).catch((e) => {
                Vue.$snitch.log({message: e.response, groups: ['auth', 'errors']})
                commit('SET_AUTHENTICATED', false)
                commit('SET_USER', null)
            })
        }
    }
}
