export default {
  CREDITOR_REQUEST: (state) => {
    state.loading = true
  },
  SET_PREFIXES: (state, data) => {
    state.prefixes = data
  },
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
  },
  STORE_SUCCESS: (state, payload) => {
    state.loading = false
    state.creditors = [...state.creditors, payload]
  },
  UPDATE_SUCCESS: (state, payload) => {
    state.loading = false
    state.creditors = state.creditors.map(c => {
      if(c.supplier_id === payload.supplier_id) {
        c = payload
      }

      return c;
    })
  },
  DELETE_SUCCESS: (state, payload) => {
    state.loading = false
    state.creditors = state.creditors.filter(c => c.supplier_id !== payload)
  },
  CREDITOR_FAILURE: (state) => {
    state.loading = false
  }
}
