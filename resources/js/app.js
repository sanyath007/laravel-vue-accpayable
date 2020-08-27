import './bootstrap'
import Vue from 'vue'
import vSelect from 'vue-select'
import VeeValidate from 'vee-validate'
import BootstrapVue from 'bootstrap-vue'
import Paginate from 'vuejs-paginate'
import Vuetify from 'vuetify'
// import { DatePicker } from 'ant-design-vue'

// import 'ant-design-vue/lib/date-picker/style/css'
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
Vue.component('paginate', Paginate)
Vue.use(VeeValidate)
Vue.use(BootstrapVue)
Vue.use(Vuetify)
// Vue.use(DatePicker)

Vue.prototype.$http = axios

axios.interceptors.response.use(response => {
  // console.log('axios interceptors', response)
  return response
}, error => {
  // console.log('axios interceptors', error)

  /** return Error object with Promise */
  return Promise.reject(error);
});

const app = new Vue({
  el: '#app',
  components: { 
    App, 
  },
  vuetify: new Vuetify(),
  router,
  store
})
