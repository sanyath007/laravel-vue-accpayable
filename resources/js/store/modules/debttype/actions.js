import axios from '../../../utils/api'

export default {
  fetchAll({ commit }) {
    commit('DEBTTYPE_REQUEST')

    axios.get('/debttypes')
      .then(res => {
        commit('SET_DEBTTYPES', res.data)
      })
      .catch(err => {
        console.log(err)
        commit('DEBTTYPE_FAILURE')
      })
  },
  fetchBySearch({ commit }, data) {
    commit('DEBTTYPE_REQUEST')

    let { searchKey, page } = data

    let url = `/debttypes/search/${searchKey}`
    url = page > 1 ? `${url}?page=${page}` : url

    axios.get(url)
      .then(res => {
        commit('SET_DEBTTYPES', res.data.debttypes.data)
        commit('SET_PAGER', res.data.debttypes)
      })
      .catch(err => {
        console.log(err)
        commit('DEBTTYPE_FAILURE')
      })
  },
  fetchById({ commit }, data) {
    commit('DEBTTYPE_REQUEST')

    axios.get('/debttypes/get-debttype/' + data)
      .then(res => {
        commit('SET_DEBTTYPE', res.data.debttype)
      })
      .catch(err => {
        console.log(err)
        commit('DEBTTYPE_FAILURE')
      })
  },
  fetchCates({ commit }) {
    axios.get('/debttypes/cates')
      .then(res => {
        commit('SET_CATES', res.data)
      })
      .catch(err => {
        console.log(err)
      })
  },
  store({ commit }, data) {
    commit('DEBTTYPE_REQUEST')
    console.log(data)

    axios.post('/debttypes', data)
      .then(res => {
        commit('STORE_SUCCESS', res.data)
      })
      .catch(err => {
        console.log(err)
        commit('DEBTTYPE_FAILURE')
      })
  },
  update({ commit }, data) {
    commit('DEBTTYPE_REQUEST')

    axios.put(`/debttypes/${data.debt_type_id}`, data)
      .then(res => {
        commit('UPDATE_SUCCESS', res.data)
      })
      .catch(err => {
        console.log(err)
        commit('DEBTTYPE_FAILURE')
      })
  },
  delete({ commit }, id) {
    commit('DEBTTYPE_REQUEST')

    axios.delete(`/debttypes/${id}`)
      .then(res => {
        commit('DELETE_SUCCESS', id)
      })
      .catch(err => {
        console.log(err)
        commit('DEBTTYPE_FAILURE')
      })
  }
}
