export default {
  isLoading: state => state.loading,
  isLoggedIn: state => !!state.token,
  getCurrentUser: state => state.currentUser,
  getUserProfile: state => state.userProfile,
  getToken: state => state.token
}
