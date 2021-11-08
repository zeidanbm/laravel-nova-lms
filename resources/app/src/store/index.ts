import Vue from 'vue'
import Vuex from 'vuex'
import navModule from '@/store/modules/navModule.ts'
import homeModule from './modules/homeModule'
import searchModule from './modules/searchModule'
import bookModule from './modules/bookModule'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		isLoading: false,
		isUpdating: Boolean(false)
	},
	mutations: {
		setIsLoading(state, value: boolean) {
			state.isLoading = value
		},
		setIsUpdating(state, value: boolean) {
			state.isUpdating = value
		}
	},
	getters: {
		getIsLoading: (state) => state.isLoading,
		getIsUpdating: (state) => state.isUpdating
	},
	actions: {},
	modules: {
		NAV: navModule,
		HOME: homeModule,
		SEARCH: searchModule,
		BOOK: bookModule
	}
})
