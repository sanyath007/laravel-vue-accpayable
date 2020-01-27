import axios from '../../../utils/api'

export default {
  fetchAll ({ commit }, data) {
    let { supplierId, startDate, endDate, showAll, page } = data

    commit('DEBTS_REQUEST')
    
    console.log('supplier=' + supplierId + ' startDate=' + startDate + ' endDate=' + endDate + ' showAll=' + showAll + ' page=' + page)
    axios.get('/debts/' + supplierId + '/' + startDate + '/' + endDate + '/' + showAll + '?page=' + page)
      .then(res => {
        commit('SET_DEBTS', res.data.debts.data)
        commit('SET_PAGER', res.data.debts)

        commit('SET_APPROVEDS', res.data.apps.data)
        commit('SET_APPROVED_PAGER', res.data.apps)

        commit('SET_PAIDS', res.data.paids.data)
        commit('SET_PAID_PAGER', res.data.paids)

        commit('SET_SETZEROS', res.data.setzeros.data)
        commit('SET_SETZERO_PAGER', res.data.setzeros)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchDebts ({ commit }, data) {
    let { url, page } = data

    commit('DEBTS_REQUEST')

    axios.get(url + '?page=' + page)
      .then(res => {
        commit('SET_DEBTS', res.data.debts.data)
        commit('SET_PAGER', res.data.debts)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchApproveds ({ commit }, data) {
    let { url, page } = data

    commit('DEBTS_REQUEST')
    
    axios.get(url + '?page=' + page)
      .then(res => {
        commit('SET_APPROVEDS', res.data.apps.data)
        commit('SET_APPROVED_PAGER', res.data.apps)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchPaids ({ commit }, data) {
    let { url, page } = data

    commit('DEBTS_REQUEST')
    
    axios.get(url + '?page=' + page)
      .then(res => {
        console.log(res)
        commit('SET_PAIDS', res.data.paids.data)
        commit('SET_PAID_PAGER', res.data.paids)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchSetZeros ({ commit }, data) {
    let { url, page } = data

    commit('DEBTS_REQUEST')
    
    axios.get(url + '?page=' + page)
      .then(res => {
        console.log(res)
        commit('SET_SETZEROS', res.data.setzeros.data)
        commit('SET_SETZERO_PAGER', res.data.setzeros)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchById ({ commit }, id) {
    axios.get('/debts/get-debt/' + id)
      .then(res => {
        console.log(res)
        commit('SET_DEBT', res.data.debt)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
