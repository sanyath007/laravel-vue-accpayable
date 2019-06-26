export default {
  AUTH_SUCCESS: (state, token) => {
    state.token = token
  },
  LOGOUT: (state) => {
    state.token = ''
    state.currentUser = null
  },
  GET_CURRENT_USER: (state, user) => {
    state.currentUser = user
  }
}

