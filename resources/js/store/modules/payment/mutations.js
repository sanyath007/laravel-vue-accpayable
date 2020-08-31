export default {
  PAYMENT_REQUEST: (state) => {
    state.loading = true
  },
  SET_PAYMENTS: (state, data) => {
    state.loading = false
    state.payments = data
  },
  SET_PAGER: (state, pager) => {
    state.pager = pager
  },
  SET_PAYMENT: (state, data) => {
    state.payment = data
  },
  SET_PAYMENT_APPROVES: (state, data) => {
    state.paymentApproves = data
  }
}
