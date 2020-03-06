export default {
  DEBTS_REQUEST: (state) => {
    state.loading = true
  },
  SET_DEBTS: (state, debts) => {
    state.loading = false
    state.debts = debts
  },
  SET_PAGER: (state, pager) => {
    state.pager = pager
  },
  SET_APPROVEDS: (state, debts) => {
    state.loading = false
    state.approveds = debts
  },
  SET_APPROVED_PAGER: (state, pager) => {
    state.approvedPager = pager
  },
  SET_PAIDS: (state, debts) => {
    state.loading = false
    state.paids = debts
  },
  SET_PAID_PAGER: (state, pager) => {
    state.paidPager = pager
  },
  SET_SETZEROS: (state, debts) => {
    state.loading = false
    state.setZeros = debts
  },
  SET_SETZERO_PAGER: (state, pager) => {
    state.setZeroPager = pager
  },
  SET_DEBT: (state, debt) => {
    state.debt = debt
  },
  CLEAR_DEBT: (state, data) => {
    state.debt = data
  },
  SET_SUM_DEBIT: (state, data) => {
    state.sumDebit = data
  },
  SET_SUM_CREDIT: (state, data) => {
    state.sumCredit = data
  },
  SET_BALANCE: (state, data) => {
    state.balance = data
  },
  STORE_SUCCESS: (state, payload) => {
    state.loading = false
  },
  UPDATE_SUCCESS: (state, payload) => {
    state.loading = false
  },
  DELETE_SUCCESS: (state, payload) => {
    state.loading = false
  },
  DEBT_FAILURE: (state) => {
    state.loading = false
  }
}
