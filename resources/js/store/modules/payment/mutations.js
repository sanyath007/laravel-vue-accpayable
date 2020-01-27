export default {
  SET_PAYMENTS: (state, data) => {
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
