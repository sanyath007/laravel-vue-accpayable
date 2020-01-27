import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  creditor: {},
  creditors: [],
  pager: {}
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
