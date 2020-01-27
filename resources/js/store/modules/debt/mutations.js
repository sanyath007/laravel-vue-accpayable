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
  }
}
