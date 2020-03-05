export default {
  APPROVE_REQUEST: (state) => {
    state.loading = true
  },
  SET_APPROVE: (state, data) => {
    state.approve = data
  },
  SET_APPROVES: (state, data) => {
    state.loading = false
    state.approves = data
  },
  SET_APPROVE_DEBTS: (state, data) => {
    state.approveDebts = data
  },
  SET_PAGER: (state, pager) => {
    state.pager = pager
  },
  CLEAR_APPROVE: (state, data) => {
    state.approve = data
  },
  SET_EDIT: (state, id) => {
    state.isEdition = true
    state.editId = id
  },
  STORE_SUCCESS: (state) => {
    state.loading = false
  },
  UPDATE_SUCCESS: (state) => {
    state.loading = false
  },
  DELETE_SUCCESS: (state) => {
    state.loading = false
  }
}
