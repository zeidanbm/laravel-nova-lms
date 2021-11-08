import { GetterTree, MutationTree } from 'vuex'
import { RootState } from '../rootState'

class State {
	isMenuOpen: boolean | false = false
}

const mutations: MutationTree<State> = {
	resetModuleState(state) {
		Object.assign(state, new State())
	},
	setIsMenuOpen(state, value) {
		state.isMenuOpen = value
	}
}

const getters: GetterTree<State, RootState> = {
	getIsMenuOpen: (state) => state.isMenuOpen
}

const navModule = {
	namespaced: true,
	state: new State(),
	mutations: mutations,
	getters: getters
}

export default navModule
