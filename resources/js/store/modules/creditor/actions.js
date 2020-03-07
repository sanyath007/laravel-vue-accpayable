import axios from '../../../utils/api'

export default {
  fetchAllWithPagination ({ commit }, data) {
    let { searchKey, page } = data
    console.log('searchKey=' + searchKey + ' page=' + page)
    axios.get('/creditors/search/' + searchKey + '?page=' + page)
      .then(res => {
        commit('SET_CREDITORS', res.data.creditors.data)
        commit('SET_PAGER', res.data.creditors)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchAll ({ commit }) {
    axios.get('/creditors/list')
      .then(res => {
        commit('SET_CREDITORS', res.data.creditors)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchById ({ commit }, data) {
    axios.get('/creditors/get-creditor/' + data)
      .then(res => {
        commit('SET_CREDITOR', res.data.creditor)
      })
      .catch(err => {
        console.log(err)
      })
  },
  update ({ commit, dispatch }, data) {
    axios.put('/creditors/update/' + data)
      .then(res => {
        console.log(res)
        dispatch('fetchAll', { searchKey: '0', page: 1 })
      })
      .catch(err => {
        console.log(err)
      })
  },
  delete ({ commit, dispatch }, data) {
    axios.delete('/creditors/delete/' + data)
    .then(res => {
      console.log(res)
      dispatch('fetchAll', { searchKey: '0', page: 1 })
    })
    .catch(err => {
      console.log(err)
    })
  }
}
