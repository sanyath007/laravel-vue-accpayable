export default {
  SET_CREDITORS: (state, data) => {
    state.creditors = data
  },
  SET_PAGER: (state, pager) => {
    state.pager = pager
  },
  SET_CREDITOR: (state, data) => {
    state.creditor = data
  },
  CLEAR_CREDITOR: (state, data) => {
    state.creditor = data
  },
  COUNT: (state) => {
    state.creditorCount = state.creditors.length
  }
}
