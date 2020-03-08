import axios from '../../../utils/api'

export default {
  fetchAllWithPagination({ commit }, data) {
    let { searchKey, page } = data
    
    let url = `/creditors/search/${searchKey}`
    url = page > 1 ? `${url}?page=${page}` : url

    console.log(url)
    axios.get(url)
      .then(res => {
        commit('SET_CREDITORS', res.data.creditors.data)
        commit('SET_PAGER', res.data.creditors)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchAll({ commit }) {
    axios.get('/creditors/list')
      .then(res => {
        commit('SET_CREDITORS', res.data.creditors)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchById({ commit }, data) {
    axios.get('/creditors/get-creditor/' + data)
      .then(res => {
        commit('SET_CREDITOR', res.data.creditor)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchPrefixes({ commit }) {
    axios.get('/creditors/prefixes')
      .then(res => {
        commit('SET_PREFIXES', res.data)
      })
      .catch(err => {
        console.log(err)
      })
  },
  store({ commit }, data) {
    axios.post('/creditors/store', data)
      .then(res => {
        console.log(res)
        commit('STORE_SUCCESS', res.data)
      })
      .catch(err => {
        console.log(err)
        commit('CREDITOR_FAILURE')
      })
  },
  update({ commit }, data) {
    axios.put(`/creditors/${data.id}`, data)
      .then(res => {
        console.log(res)
        commit('UPDATE_SUCCESS', res.data)
      })
      .catch(err => {
        console.log(err)
        commit('CREDITOR_FAILURE')
      })
  },
  delete({ commit }, id) {
    axios.delete(`/creditors/${id}`)
    .then(res => {
      console.log(res)
      commit('DELETE_SUCCESS', id)
    })
    .catch(err => {
      console.log(err)
      commit('CREDITOR_FAILURE')
    })
  }
}
