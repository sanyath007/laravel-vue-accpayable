import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  creditor: {},
  creditors: [],
  pager: {},
  creditorCount: 0
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
