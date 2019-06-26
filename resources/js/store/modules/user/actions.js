import axios from "axios";
import jwt_decode  from 'jwt-decode'

export default {
  login: ({ commit, dispatch }, user) => {
    axios.post('/api/auth/login', user)
      .then(res => {
        console.log(res)
        const token = res.data.access_token
        const decoded = jwt_decode(token)
        const userId = decoded.sub

        localStorage.setItem('token', token)
        axios.defaults.headers.common['Authorization'] = token

        commit('AUTH_SUCCESS', token)
        dispatch('getCurrentUser', token, userId)
      })
      .catch(err => {
        console.log(err)
        localStorage.removeItem('token')
      })      
  },
  logout: ({ commit }) => {
    commit('LOGOUT')
    localStorage.removeItem('token')
  },
  getCurrentUser: ({ commit }, token, userId) => {
    axios.defaults.headers.common['Authorization'] = `bearer ${token}`

    axios.get('/api/auth/user', userId)
      .then(res => {
        const user = res.data.data
        console.log(user)
        commit('GET_CURRENT_USER', user)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
