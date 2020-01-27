import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  debttype: {},
  debttypes: [],
  pager: {}
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
