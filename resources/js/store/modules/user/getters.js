export default {
  isLoggedIn: state => !!state.token,
  currentUser: state => state.currentUser
}
