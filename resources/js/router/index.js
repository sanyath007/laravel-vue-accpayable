import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../components/Home'
import Login from '../components/Login'
import Register from '../components/Register'
import Debt from '../components/Debt'

Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/',
			name: 'home',
			component: Home
		},
		{
			path: '/debt',
			name: 'debt',
			component: Debt,
			meta: {
				auth: false
			}
		},
		{
			path: '/login',
			name: 'login',
			component: Login,
			meta: {
				auth: false
			}
		},
		{
			path: '/register',
			name: 'register',
			component: Register,
			meta: {
				auth: false
			}
		},
		// otherwise redirect to home
		{ path: '*', redirect: '/' }
	],
})

export default router
