import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  token: localStorage.getItem('token') || '',
  loading: false,
  currentUser: null,
  userProfile: {},
  authErrors: null
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
