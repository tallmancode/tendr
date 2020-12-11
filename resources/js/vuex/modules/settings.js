export default {
    namespaced: true,
    state: {
        generalSettings: []
    },

    mutations: {
       SET_GENERAL_SETTINGS(state, generalSettings){
           state.generalSettings = generalSettings
       }
    },

    actions: {
        async init({ dispatch }) {
            await dispatch('getGeneralSettings')
        },
        async getGeneralSettings({commit}) {
            await axios.get('/api/settings/general')
            .then((res) => {
                Vue.$snitch.log({message: 'settings/getGeneralSettings', groups: ['settings'], info: false})
                Vue.$snitch.log({message: res, groups: ['settings'] })
                commit('SET_GENERAL_SETTINGS', res.data)
                return true
            })
        },
        async getSettingsByGroup({commit}, group) {
            console.log('getSettingsByGroup')
            return await axios.get('/api/settings/'+group)
            .then((res) => {
                Vue.$snitch.log({message: 'settings/getSettingsByGroup', groups: ['settings'], info: false})
                Vue.$snitch.log({message: res, groups: ['settings'] })
                return res.data
            })
        }
    },

    getters: {
        getAllSettings(state){
            Vue.$snitch.log({message: 'settings/getAllSettings', groups: ['settings'], info: false})
            Vue.$snitch.log({message: state.generalSettings, groups: ['settings'] })
            return {
                generalSettings: state.generalSettings
            }
        }
    },
}
