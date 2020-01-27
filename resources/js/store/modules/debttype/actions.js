import axios from '../../../utils/api'

export default {
  fetchAll ({ commit }, data) {
    let { searchKey, page } = data
    console.log('searchKey=' + searchKey + ' page=' + page)
    axios.get('/debttypes/search/' + searchKey + '?page=' + page)
      .then(res => {
        console.log(res)
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
        console.log(res)
        commit('SET_DEBTTYPE', res.data.debttype)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
