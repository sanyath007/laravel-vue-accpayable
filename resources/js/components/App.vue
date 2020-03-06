<template>
  <div :style="containerBackgroundStyle">
    <header-section :is-logged-in="isLoggedIn" :current-user="currentUser" />

    <main>
      <section class="section-1">
        <router-view></router-view>
      </section>
    </main>

    <footer-section />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import jwtDecode from 'jwt-decode'
import moment from 'moment'

import Header from './Header'
import Footer from './Footer'

export default {
  name: 'App',
  components: {
    'header-section': Header,
    'footer-section': Footer
  },
  data () {
    return {

    }
  },
  mounted () {
    this.checkAuth()
  },
  computed: {
    ...mapGetters({
      isLoggedIn: 'user/isLoggedIn',
      currentUser: 'user/getUserProfile',
      token: 'user/getToken',
      currentPage: 'page/getCurrentPage'
    }),
    containerBackgroundStyle: function () {
      let bg = (this.currentPage === 'login' || this.currentPage === 'register')
                  ? "url('http://accpayable.com/img/mountain.png') no-repeat center center fixed"
                  : 'white'
      return {
        background: bg,
        backgroundSize: 'cover'
      }
    }
  },
  methods: {
    checkAuth () {
      if (this.token) {
        let decoded = jwtDecode(this.token)
        let isNotExpired = Date.now() < moment.unix(decoded.exp).toDate()

        console.log(Date.now() < moment.unix(decoded.exp).toDate())

        if (isNotExpired && this.isLoggedIn) {
          this.$store.dispatch('user/fetchUserProfile', decoded.sub)
          // this.$store.commit('user/SET_CURRENT_USER', decoded.sub)
        } else {
          this.$store.dispatch('user/logout')
        }
      } else {
        this.$store.dispatch('user/logout')
      }
    }
  }
}
</script>

<style scoped>
.section-1 {
  padding: 2vmin 0vmin;
  min-height: 400px;
}
</style>
