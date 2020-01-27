import './bootstrap'
import Vue from 'vue'
import vSelect from 'vue-select'
import VeeValidate from 'vee-validate'
import BootstrapVue from 'bootstrap-vue'
import Paginate from 'vuejs-paginate'

import 'vue-select/dist/vue-select.css'
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import axios from './utils/api'

import App from './components/App'

import router from './router'
import store from './store'

Vue.config.productionTip = false

Vue.component('v-select', vSelect)
Vue.component('paginate', Paginate)
Vue.use(VeeValidate)
Vue.use(BootstrapVue)

Vue.filter('currency', function (value) {
  return parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
})

Vue.filter('thdate', function (date) {
  if (!date) return;
  let arr = date.split('-')
  return arr[2] + '/' + arr[1] + '/' + (parseInt(arr[0]) + 543)
})

Vue.prototype.$http = axios

const app = new Vue({
  el: '#app',
  components: { 
    App, 
  },
  router,
  store,
})
