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
  sumDebit: 0.0,
  sumCredit: 0.0,
  balance: 0.0
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
