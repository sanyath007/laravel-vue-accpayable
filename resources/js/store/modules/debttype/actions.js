import axios from '../../../utils/api'

export default {
  fetchAll ({ commit }) {
    axios.get('/debttypes')
      .then(res => {
        commit('SET_DEBTTYPES', res.data)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchBySearch ({ commit }, data) {
    let { searchKey, page } = data

    axios.get('/debttypes/search/' + searchKey + '?page=' + page)
      .then(res => {
        commit('SET_DEBTTYPES', res.data.debttypes.data)
        commit('SET_PAGER', res.data.debttypes)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchById ({ commit }, data) {
    axios.get('/debttypes/get-debttype/' + data)
      .then(res => {
        commit('SET_DEBTTYPE', res.data.debttype)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
