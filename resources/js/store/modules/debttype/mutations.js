export default {
  DEBTTYPE_REQUEST: (state, data) => {
    state.loading = true
  },
  SET_DEBTTYPES: (state, data) => {
    state.loading = false
    state.debttypes = data
  },
  SET_PAGER: (state, pager) => {
    state.pager = pager
  },
  SET_DEBTTYPE: (state, data) => {
    state.loading = false
    state.debttype = data
  },
  CLEAR_DEBTTYPE: (state, data) => {
    state.loading = false
    state.debttype = data
  },
  STORE_SUCCESS: (state, payload) => {
    state.loading = false
    state.debttypes = [...state.debttypes, payload]
  },
  UPDATE_SUCCESS: (state, payload) => {
    state.loading = false
    state.debttypes = state.debttypes.map(d => {
      if(d.debt_type_id === payload.debt_type_id) {
        d = payload
      }
      
      return d
    })
  },
  DELETE_SUCCESS: (state, payload) => {
    state.loading = false
    state.debttypes = state.debttypes.filter(d => d.debt_type_id !== payload)
  },
  DEBTTYPE_FAILURE: (state, data) => {
    state.loading = false
  },
  SET_CATES: (state, payload) => {
    state.cates = payload
  }
}
