import Vue from 'vue'
import VueToast from 'vue-toast-notification'
import axios from '../../../utils/api'

import 'vue-toast-notification/dist/index.css'

Vue.use(VueToast)

export default {
  fetchAll({ commit }, data) {
    let { url, page } = data
    
    commit('APPROVE_REQUEST')

    const endpoint = page === 1 ? url : `${url}?page=${page}`
    
    axios.get(endpoint)
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
    commit('APPROVE_REQUEST')
    
    axios.get(`/approves/${approveId}`)
    .then(res => {
      commit('SET_APPROVE', res.data.approvement)
      commit('SET_APPROVE_DEBTS', res.data.detail)
    })
    .catch(err => {
      console.log(err)
    })
  },
  store({ commit }, data) {
    console.log(data)
    commit('APPROVE_REQUEST')

    axios.post('/approves/store', data)
      .then(res => {
        console.log(res)
        Vue.$toast.success('Insert successful!!', { position: 'top-right' })

        commit('STORE_SUCCESS')
      })
      .catch(err => {
        console.log(err)
        Vue.$toast.error('Error!!', { position: 'top-right' })
      })
    },
  update({ commit }, payload) {
    console.log(payload)
    commit('APPROVE_REQUEST')
    
    axios.put(`/approves/${payload.app_id}`, payload)
      .then(res => {
        console.log(res)
        Vue.$toast.success('Update successful!!', { position: 'top-right' })
      })
      .catch(err => {
        console.log(err)
        Vue.$toast.error('Error!!', { position: 'top-right' })
      })
  },
  delete({ commit }, id) {
    console.log(id)
    commit('APPROVE_REQUEST')

    axios.delete(`/approves/${id}`)
      .then(res => {
        console.log(res)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
