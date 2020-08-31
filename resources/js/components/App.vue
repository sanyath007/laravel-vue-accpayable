<template>
  <v-app :style="containerBackgroundStyle">
    <header-section :is-logged-in="isLoggedIn" :current-user="currentUser" />

    <!-- Vuetify Theme-->
    <!--<v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list dense>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-home</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-email</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Contact</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>-->

    <!--<v-app-bar
      app
      color="indigo"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Accpayable System</v-toolbar-title>
    </v-app-bar>-->

    <v-main>
      <v-container
        fluid
      >
        <v-row>
          <v-col>
            <router-view></router-view>
            <!--<v-tooltip left>
              <template v-slot:activator="{ on }">
                <v-btn
                  :href="source"
                  icon
                  large
                  target="_blank"
                  v-on="on"
                >
                  <v-icon large>mdi-code-tags</v-icon>
                </v-btn>
              </template>
              <span>Source</span>
            </v-tooltip>-->
          </v-col>
        </v-row>

      </v-container>
    </v-main>
    
    <v-footer
      color="purple darken-4"
      app
    >
      <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
    <!--<footer-section />-->
    
  </v-app>
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
  props: {
    source: String,
  },
  data: () => ({
    drawer: null,
  }),
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
