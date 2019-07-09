import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../components/home/Home'
import Login from '../components//login/Login'
import Register from '../components/register/Register'
import Debt from '../components/debt/Debt'

Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/home',
			name: 'home',
			component: Home,
			meta: {
				auth: true
			}
		},
		{
			path: '/debt',
			name: 'debt',
			component: Debt,
			meta: {
				auth: true
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
		{ path: '*', redirect: '/login' }
	],
})

export default router
