export default {
  SET_BUDGETS: (state, data) => {
    state.budgets = data
  },
  SET_BUDGET: (state, data) => {
    state.budget = data
  },
  CLEAR_BUDGET: (state) => {
    state.budget = null
  }
}
