export default {
  isLoading: state => state.loading,
  getById: state => state.debt,
  getAll: state => state.debts,
  getPager: state => state.pager,
  getApproveds: state => state.approveds,
  getApprovedPager: state => state.approvedPager,
  getPaids: state => state.paids,
  getPaidPager: state => state.paidPager,
  getSetZeros: state => state.setZeros,
  getSetZeroPager: state => state.setZeroPager
}
