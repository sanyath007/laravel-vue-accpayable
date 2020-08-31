import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  loading: false,
  payment: [],
  payments: [],
  paymentApproves: [],
  pager: {}
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
