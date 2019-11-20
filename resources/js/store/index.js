import Vue from 'vue'
import Vuex from 'vuex'
import page from './modules/page'
import user from './modules/user'
import task from './modules/task'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    page,
    user,
    task,
  },
  strict: debug,
})