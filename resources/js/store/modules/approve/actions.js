import Vue from 'vue'
import VueToast from 'vue-toast-notification'
import axios from '../../../utils/api'

import 'vue-toast-notification/dist/index.css'

export default {
  fetchAll({ commit }, data) {
    let { url, page } = data
    
    commit('APPROVE_REQUEST')

    axios.get(`${url}?page=${page}`)
      .then(res => {
        commit('SET_APPROVES', res.data.approvements.data)
        commit('SET_APPROVE_DEBTS', res.data.approvement_debts)
        commit('SET_PAGER', res.data.approvements)
      })
      .catch(err => {
        console.log(err)
      })
  },
  fetchById({ commit }, approveId) {
    axios.get('/approves/get-approve/' + approveId)
      .then(res => {
        console.log(res)
        commit('SET_APPROVE', res.data.approvement)
      })
      .catch(err => {
        console.log(err)
      })
  },
  store({ commit }, data) {
    console.log(data)

    axios.post('/approves/store', data)
      .then(res => {
        console.log(res)
        Vue.$toast.success('Test Toast!!!', { position: 'top-right' })
      })
      .catch(err => {
        console.log(err)
        Vue.$toast.error('Test Toast!!!', { position: 'top-right' })
      })
  },
  update({ commit }, data) {
    console.log(data)

    axios.put('/approves/update', data)
      .then(res => {
        console.log(res)
      })
      .catch(err => {
        console.log(err)
      })
  },
  delete({ commit }, approveId) {

  }
}
