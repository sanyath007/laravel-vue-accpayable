export default {
  AUTH_REQUEST: (state) => {
    state.loading = true
  },
  AUTH_SUCCESS: (state, payload) => {
    state.loading = false
    state.token = payload.token
    state.currentUser = payload.userId
  },
  AUTH_FAILED: (state, payload) => {
    state.loading = false
    state.token = ''
    state.currentUser = ''
    state.authErrors = payload
  },
  SET_USER_PROFILE: (state, user) => {
    state.userProfile = user
  },
  LOGOUT: (state) => {
    state.token = ''
    state.currentUser = null
    state.userProfile = {}
  }
}
