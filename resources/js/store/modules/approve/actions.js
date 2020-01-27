import axios from '../../../utils/api'

export default {
  fetchAll ({ commit }, data) {
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
  fetchById ({ commit }, approveId) {
    axios.get('/approves/get-approve/' + approveId)
      .then(res => {
        console.log(res)
        commit('SET_APPROVE', res.data.approvement)
      })
      .catch(err => {
        console.log(err)
      })
  }
}
