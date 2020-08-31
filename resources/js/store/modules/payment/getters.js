export default {
  isLoading: state => state.loading,
  getById: state => state.payment,
  getAll: state => state.payments,
  getPaymentApproves: state => state.paymentApproves,
  getPager: state => state.pager
}
