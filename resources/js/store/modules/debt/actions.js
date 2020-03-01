import Vue from 'vue'
import VueToast from 'vue-toast-notification'
import axios from '../../../utils/api'

import 'vue-toast-notification/dist/index.css'

Vue.use(VueToast)

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
      commit('SET_DEBT', res.data.debt)
    })
    .catch(err => {
      console.log(err)
    })
  },
  fetchSumDebit({ commit }) {
    axios.get('/debts/sum-debit')
    .then(res => {
      commit('SET_SUM_DEBIT', res.data)
    })
    .catch(err => {
      console.log(err)
    })
  },
  fetchSumCredit({ commit }) {
    axios.get('/debts/sum-credit')
    .then(res => {
      Vue.$toast.success('Test Toast!!!', { position: 'top-right' })
      commit('SET_SUM_CREDIT', res.data)
    })
    .catch(err => {
      console.log(err)
      Vue.$toast.error('Test Toast!!!', { position: 'top-right' })
    })
  },
  fetchBalance({ commit }) {
    axios.get('/debts/balance')
    .then(res => {
      commit('SET_BALANCE', res.data)
    })
    .catch(err => {
      console.log(err)        
    })
  }
}
