import axios from '../../../utils/api'
import { getDate } from '../../../utils/date-func'

export default {
  getAll ({ commit }, data) {
    let { url, page } = data
    
    commit('PAYMENT_REQUEST')

    const endpoint = page === 1 ? url : `${url}?page=${page}`
    
    axios.get(endpoint)
    .then(res => {
        commit('SET_PAYMENTS', res.data.payments.data)
        commit('SET_PAGER', res.data.payments)
      })
      .catch(err => {
        console.log(err)
      })
  },
  getById ({ commit }, paymentId) {
    axios.get('/payments/get-payment/' + paymentId)
      .then(res => {
        console.log(res)
        commit('SET_PAYMENT', res.data.payment)
      })
      .catch(err => {
        console.log(err)
      })
  },
  getPaymentApproves ({ commit }, supplierId) {
    axios.get('/payments/' + supplierId + '/list')
      .then(res => {
        console.log(res)
        commit('SET_PAYMENT_APPROVES', res.data.paymentApproves)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
