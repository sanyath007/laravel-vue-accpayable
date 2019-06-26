import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  token: localStorage.getItem('token') || '',
  currentUser: null,
  isAdmin: false,
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
}