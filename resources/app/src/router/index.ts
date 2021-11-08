import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
	{
		path: '/',
		name: 'Home',
		component: Home
	},
	{
		path: '/periodics',
		name: 'Periodics',
		component: () => import(/* webpackChunkName: "periodics-view" */ '../views/Periodics.vue')
	},
	{
		path: '/events',
		name: 'Events',
		component: () => import(/* webpackChunkName: "events-view" */ '../views/Events.vue')
	},
	{
		path: '/about',
		name: 'About',
		component: () => import(/* webpackChunkName: "about-view" */ '../views/About.vue')
	},
	{
		path: '/search',
		name: 'Results',
		component: () => import(/* webpackChunkName: "results-view" */ '../views/Results.vue'),
		props: (route) => ({ query: route.query.q })
	},
	{
		path: '/book/:slug',
		name: 'Book',
		component: () => import(/* webpackChunkName: "book" */ '../views/Book.vue'),
		props: (route) => ({ slug: route.params.slug })
	}
]

const router = new VueRouter({
	mode: 'history',
	base: '/',
	routes
})

export default router
