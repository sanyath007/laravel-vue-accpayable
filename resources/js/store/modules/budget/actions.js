import axios from '../../../utils/api'

export default {
  fetchAll ({ commit }) {
    axios.get('/budgets')
    .then(res => {
        commit('SET_BUDGETS', res.data)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchById ({ commit }, id) {
    axios.get(`/budgets/${id}`)
      .then(res => {
        commit('SET_BUDGET', res.data)
      })
      .catch(err => {
        console.log(err)
      })
  },
  update ({ commit, dispatch }, data) {
    axios.put('/budgets/update/' + data)
      .then(res => {
        console.log(res)
        dispatch('fetchAll', { searchKey: '0', page: 1 })
      })
      .catch(err => {
        console.log(err)
      })
  },
  delete ({ commit, dispatch }, data) {
    axios.delete('/budgets/delete/' + data)
    .then(res => {
      console.log(res)
      dispatch('fetchAll', { searchKey: '0', page: 1 })
    })
    .catch(err => {
      console.log(err)
    })
  }
}
