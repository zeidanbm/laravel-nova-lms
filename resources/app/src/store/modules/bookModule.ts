import { GetterTree, MutationTree, ActionTree } from 'vuex'
import { RootState } from '../rootState'
import { api } from '../api'
import { BookResponse } from '@/interfaces/Response'
import { Book } from '@/interfaces/Book'

class State {
	book: Book

	constructor() {
		this.book = {} as Book
	}
}

const mutations: MutationTree<State> = {
	resetModuleState(state) {
		Object.assign(state, new State())
	},
	setBook(state, value: Book) {
		state.book = value
	}
}

const getters: GetterTree<State, RootState> = {
	getBook: (state) => state.book
}

const actions: ActionTree<State, RootState> = {
	retrieveBook({ commit }, slug) {
		commit('setIsLoading', true, { root: true })
		api.getData(`/api/book?slug=${slug}`).then((response: BookResponse) => {
			commit('setBook', response.data)
		})
	}
}

const bookModule = {
	namespaced: true,
	state: new State(),
	mutations: mutations,
	getters: getters,
	actions: actions
}

export default bookModule
