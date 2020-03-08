export default {
  isLoading: state => state.loading,
  getPrefixes: state => state.prefixes,
  getById: state => state.creditor,
  getAll: state => state.creditors,
  getPager: state => state.pager,
  getCount: state => state.creditorCount
}
