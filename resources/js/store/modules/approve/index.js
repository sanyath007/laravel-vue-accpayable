import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  loading: false,
  approve: {},
  approves: [],
  approveDebts: [],
  pager: {}
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
