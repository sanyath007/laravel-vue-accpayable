import Vue from 'vue'
import Vuex from 'vuex'
import page from './modules/page'
import user from './modules/user'
import debt from './modules/debt'
import approve from './modules/approve'
import payment from './modules/payment'
import creditor from './modules/creditor'
import debttype from './modules/debttype'
import budget from './modules/budget'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    page,
    user,
    debt,
    approve,
    payment,
    creditor,
    debttype,
    budget
  },
  strict: debug
})
