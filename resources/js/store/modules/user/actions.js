import axios from 'axios'
import jwtDecode from 'jwt-decode'
import router from '../../../router'

axios.defaults.baseURL = 'http://accpayable.com/api'

export default {
  login: ({ commit, dispatch }, user) => {
    commit('AUTH_REQUEST')

    axios.post('/auth/login', user)
      .then(res => {
        const token = res.data.access_token
        const decoded = jwtDecode(token)
        const userId = decoded.sub

        localStorage.setItem('token', token)

        commit('AUTH_SUCCESS', {token, userId})
        dispatch('fetchUserProfile', userId)

        axios.defaults.headers.common['Authorization'] = `bearer ${token}`

        router.push('/home')
      })
      .catch(err => {
        localStorage.removeItem('token')

        commit('AUTH_FAILED', { code: '500', message: 'Internal Error'})
      })
  },
  logout: ({ commit }) => {
    commit('LOGOUT')
    localStorage.removeItem('token')
  },
  fetchUserProfile: ({ commit }, userId) => {
    axios.defaults.headers.common['Authorization'] = `bearer ${localStorage.getItem('token')}`

    axios.get('/auth/user', userId)
      .then(res => {
        const user = res.data.data
        
        commit('SET_USER_PROFILE', user)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
