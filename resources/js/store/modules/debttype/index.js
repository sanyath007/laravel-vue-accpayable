import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  loading: false,
  debttype: {},
  debttypes: [],
  pager: {},
  cates: []
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
