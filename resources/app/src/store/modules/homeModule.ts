import { GetterTree, MutationTree, ActionTree } from 'vuex'
import { RootState } from '../rootState'
import { api } from '../api'
import { OwnedResponse, FeaturedResponse } from '@/interfaces/Response'

interface Publication {
	book_id?: string
	periodic_id?: string
	post_id: string
	title: string
	url: string
	slug: string
	created_at: string
}

class State {
	ownedPublications: Publication[]
	featuredPublications: Publication[]

	constructor() {
		this.ownedPublications = []
		this.featuredPublications = []
	}
}

const mutations: MutationTree<State> = {
	resetModuleState(state) {
		Object.assign(state, new State())
	},
	setOwnedPublications(state, value: Publication[]) {
		state.ownedPublications = value
	},
	setFeaturedPublications(state, value: Publication[]) {
		state.featuredPublications = value
	}
}

const getters: GetterTree<State, RootState> = {
	getOwnedPublications: (state) => state.ownedPublications,
	getFeaturedPublications: (state) => state.featuredPublications
}

const actions: ActionTree<State, RootState> = {
	retrieveOwnedPublications({ commit }, perPage = '15') {
		api.getData(`/api/owned-catalogs?per_page=${perPage}`).then((response: OwnedResponse) => {
			commit('setOwnedPublications', response.data)
		})
	},
	retrieveFeaturedPublications({ commit }, perPage = '15') {
		api.getData(`/api/featured-catalogs?per_page=${perPage}`).then((response: FeaturedResponse) => {
			commit('setFeaturedPublications', response.data)
		})
	}
}

const homeModule = {
	namespaced: true,
	state: new State(),
	mutations: mutations,
	getters: getters,
	actions: actions
}

export default homeModule
