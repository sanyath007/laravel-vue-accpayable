import './bootstrap'
import Vue from 'vue'
import vSelect from 'vue-select'
import VeeValidate from 'vee-validate'
import BootstrapVue from 'bootstrap-vue'
import Paginate from 'vuejs-paginate'

import 'vue-select/dist/vue-select.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import App from './components/App'

import axios from './utils/api'
import router from './router'
import store from './store'
import './filters'

Vue.config.productionTip = false

Vue.component('v-select', vSelect)
Vue.component('paginate', Paginate)
Vue.use(VeeValidate)
Vue.use(BootstrapVue)

Vue.prototype.$http = axios

axios.interceptors.response.use(response => {
  console.log('axios interceptors')
  console.log(response)
  return response
}, error => {
  console.log(error)
  // return Error object with Promise
  return Promise.reject(error);
});

const app = new Vue({
  el: '#app',
  components: { 
    App, 
  },
  router,
  store,
})
