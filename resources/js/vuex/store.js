import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import company from './modules/company'
import settings from './modules/settings'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    company,
    settings
  }
})
