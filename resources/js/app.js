import './bootstrap'
import Vue from 'vue'
import vSelect from 'vue-select'
import VeeValidate from 'vee-validate'
import BootstrapVue from 'bootstrap-vue'
import Vuetify from 'vuetify'

import 'vue-select/dist/vue-select.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vuetify/dist/vuetify.min.css'

import App from './components/App'

import axios from './utils/api'
import router from './router'
import store from './store'
import './filters'

Vue.config.productionTip = false

Vue.component('v-select', vSelect)
Vue.use(VeeValidate)
Vue.use(BootstrapVue)
Vue.use(Vuetify)

Vue.prototype.$http = axios

axios.interceptors.response.use(response => {
  return response
}, error => {
  /** return Error object with Promise */
  return Promise.reject(error);
});

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  components: { App },
  router,
  store
})
