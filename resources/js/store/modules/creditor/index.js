import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  loading: false,
  prefixes: [],
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
