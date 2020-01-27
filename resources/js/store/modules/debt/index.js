import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  loading: false,
  debt: {},
  debts: [],
  pager: {},
  approveds: [],
  approvedPager: {},
  paids: [],
  paidPager: {},
  setZeros: [],
  setZeroPager: {},
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
