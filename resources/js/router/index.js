import Vue from 'vue'
import VueRouter from 'vue-router'

import LoginPage from '../views/LoginPage'
import RegisterPage from '../views/RegisterPage'
import HomePage from '../views/HomePage'
import DebtPage from '../views/DebtPage'
import ApprovePage from '../views/ApprovePage'
import ApproveForm from '../components/approve/Form'
import PaymentPage from '../views/PaymentPage'
import PaymentForm from '../components/payment/Form'
import CreditorPage from '../views/CreditorPage'
import DebtTypePage from '../views/DebtTypePage'

import store from '../store'

Vue.use(VueRouter)

const router = new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/',
			name: 'home',
			component: HomePage,
			meta: {
				requiresAuth: true
			}
		},
		{
			path: '/debt',
			name: 'debt',
			component: DebtPage,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/approve',
			name: 'approve',
			component: ApprovePage,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/approve/form',
			name: 'approve-form',
			component: ApproveForm,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/payment',
			name: 'payment',
			component: PaymentPage,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/payment/form',
			name: 'payment-form',
			component: PaymentForm,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/creditor',
			name: 'creditor',
			component: CreditorPage,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/debttype',
			name: 'debttype',
			component: DebtTypePage,
			meta: {
				requiresAuth: true
				// is_admin : true
			}
		},
		{
			path: '/login',
			name: 'login',
			component: LoginPage,
			meta: {
				requiresAuth: false
			}
		},
		{
			path: '/register',
			name: 'register',
			component: RegisterPage,
			meta: {
				requiresAuth: false
			}
		},
		{// otherwise redirect to home
			path: '*',
			redirect: '/'
		}
	]
})

/** Guad router */
router.beforeEach((to, from, next) => {
	const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
	const isLoggedIn = store.getters['user/isLoggedIn']

	if (requiresAuth && !isLoggedIn) {
			next('/login')
	} else if (requiresAuth && isLoggedIn) {
			next()
	} else {
			next()
	}
})

export default router
