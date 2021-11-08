import { GetterTree, MutationTree, ActionTree } from 'vuex'
import { RootState } from '../rootState'
import { api } from '../api'
import { SelectOption } from '@/interfaces/Select'
import { topicsList, bookFieldsList, typeList } from '@/lists/SearchList'
import { SearchResult, Bucket } from '@/interfaces/Search'
import { AutocompleteResponse, SearchResponse, SearchData, SuggestionOption } from '@/interfaces/Response'

class State {
	page: number
	lastPage: number
	totalResults: number
	suggestions: string[]
	isSuggestionsOpen: boolean
	isAdvancedSearchOpen: boolean
	searchTerm: string
	searchResults: SearchResult[]
	advTypeFilter: string[]
	advTopicFilter: SelectOption[]
	typeFilter: string[]
	topicFilter: string[]
	subTopicFilter: string[]
	tagFilter: string[]
	authorFilter: string[]
	bookSearchFields: string[]
	typeBuckets: Bucket[]
	topicBuckets: Bucket[]
	subTopicBuckets: Bucket[]
	tagBuckets: Bucket[]
	authorBuckets: Bucket[]

	constructor(term = '') {
		this.page = 1
		this.lastPage = 1
		this.totalResults = 0
		this.suggestions = []
		this.isSuggestionsOpen = false
		this.isAdvancedSearchOpen = false
		this.searchTerm = term
		this.searchResults = []
		this.advTypeFilter = [...typeList]
		this.advTopicFilter = [...topicsList]
		this.typeFilter = []
		this.topicFilter = []
		this.subTopicFilter = []
		this.tagFilter = []
		this.authorFilter = []
		this.bookSearchFields = [...bookFieldsList]
		this.typeBuckets = []
		this.topicBuckets = []
		this.subTopicBuckets = []
		this.tagBuckets = []
		this.authorBuckets = []
	}
}

const mutations: MutationTree<State> = {
	resetModuleState(state, term) {
		Object.assign(state, new State(term))
	},
	resetSearchResults(state) {
		state.searchResults = []
	},
	resetAdvancedSearch(state) {
		state.advTypeFilter = [...typeList]
		state.bookSearchFields = [...bookFieldsList]
		state.advTopicFilter = [...topicsList]
	},
	resetBookFilters(state) {
		state.bookSearchFields = [...bookFieldsList]
		state.advTopicFilter = [...topicsList]
	},
	resetSuggestions(state) {
		state.suggestions = []
	},
	setPage(state, value) {
		state.page = value
	},
	setLastPage(state, value: number) {
		state.lastPage = Math.ceil(value / 20)
	},
	incrementPage(state, value) {
		state.page += value
	},
	setTotalResults(state, value) {
		state.totalResults = value
	},
	setSuggestions(state, result: SuggestionOption[]) {
		const res = result.map((item) => {
			return item.text
		})
		res.sort((a: string, b: string) => a.length - b.length)
		state.suggestions = res
	},
	setIsSuggestionsOpen(state, value) {
		state.isSuggestionsOpen = value
	},
	setIsAdvancedSearchOpen(state, value: boolean) {
		state.isAdvancedSearchOpen = value
	},
	setSearchTerm(state, value: string) {
		state.searchTerm = value
	},
	setSearchResults(state, res: SearchData) {
		state.searchResults = res.results.map((item) => {
			return item._source
		})
	},
	pushToSearchResults(state, res: SearchData) {
		state.searchResults.push(
			...res.results.map((item) => {
				return item._source
			})
		)
	},
	setAdvTypeFilter(state, value: string[]) {
		state.advTypeFilter = value
	},
	setAdvTopicFilter(state, value: SelectOption) {
		if (value.isMarked) {
			const index: number = state.advTopicFilter.indexOf(value)
			value.class = 'font-normal'
			value.isMarked = false
			state.advTopicFilter.splice(index, 1)
		} else {
			value.class = 'font-bold'
			value.isMarked = true
			state.advTopicFilter.push(value)
		}
	},
	setTypeFilter(state, value: string[]) {
		state.typeFilter = value
	},
	setTopicFilter(state, value: string[]) {
		state.topicFilter = value
	},
	setSubTopicFilter(state, value: string[]) {
		state.subTopicFilter = value
	},
	setTagFilter(state, value: string[]) {
		state.tagFilter = value
	},
	setAuthorFilter(state, value: string[]) {
		state.authorFilter = value
	},
	setBookSearchFields(state, value) {
		state.bookSearchFields = value
	},
	setSearchTermAsSuggestion(state, value: number) {
		state.searchTerm = state.suggestions[value]
	},
	setTypeBuckets(state, value) {
		state.typeBuckets = value.buckets
		state.typeFilter = value.buckets.map((item: Bucket) => (item.doc_count ? item.key : false))
	},
	setTopicBuckets(state, value) {
		state.topicBuckets = value.buckets
		state.topicFilter = value.buckets.map((item: Bucket) => item.key)
	},
	setSubTopicBuckets(state, value) {
		state.subTopicBuckets = value.buckets
		state.subTopicFilter = value.buckets.map((item: Bucket) => item.key)
	},
	setTagBuckets(state, value) {
		state.tagBuckets = value.buckets
		state.tagFilter = value.buckets.map((item: Bucket) => item.key)
	},
	setAuthorBuckets(state, value) {
		state.authorBuckets = value.buckets
		state.authorFilter = value.buckets.map((item: Bucket) => item.key)
	},
	updateTypeBuckets(state, value) {
		state.typeBuckets = value.buckets
	},
	updateTopicBuckets(state, value) {
		state.topicBuckets = value.buckets
	},
	updateSubTopicBuckets(state, value) {
		state.subTopicBuckets = value.buckets
	},
	updateTagBuckets(state, value) {
		state.tagBuckets = value.buckets
	},
	updateAuthorBuckets(state, value) {
		state.authorBuckets = value.buckets
	}
}

const getters: GetterTree<State, RootState> = {
	getPage: (state) => state.page,
	getLastPage: (state) => state.lastPage,
	getTotalResults: (state) => state.totalResults,
	getSuggestions: (state) => state.suggestions,
	getTotalSuggestions: (state) => state.suggestions.length,
	getIsSuggestionsOpen: (state) => state.isSuggestionsOpen,
	getIsAdvancedSearchOpen: (state) => state.isAdvancedSearchOpen,
	getSearchTerm: (state) => state.searchTerm,
	getSearchResults: (state) => state.searchResults,
	getAdvTypeFilter: (state) => state.advTypeFilter,
	getAdvTopicFilter: (state) => state.advTopicFilter,
	getTypeFilter: (state) => state.typeFilter,
	getTopicFilter: (state) => state.topicFilter,
	getSubTopicFilter: (state) => state.subTopicFilter,
	getTagFilter: (state) => state.tagFilter,
	getAuthorFilter: (state) => state.authorFilter,
	getBookSearchFields: (state) => state.bookSearchFields,
	getTypeBuckets: (state) => state.typeBuckets,
	getTopicBuckets: (state) => state.topicBuckets,
	getSubTopicBuckets: (state) => state.subTopicBuckets,
	getTagBuckets: (state) => state.tagBuckets,
	getAuthorBuckets: (state) => state.authorBuckets
}

const actions: ActionTree<State, RootState> = {
	retrieveSuggestions: ({ commit, state }) => {
		api.getData(`/api/autocomplete?s=${state.searchTerm}`).then((res: AutocompleteResponse) => {
			commit('setSuggestions', res?.data?.options)
		})
	},
	retrieveSearchResults: async ({ commit, state }, term = '') => {
		term = term || state.searchTerm
		commit('setIsLoading', true, { root: true })
		const topics = state.advTopicFilter.map((a) => a.label)
		await api
			.getData(
				`/api/search?s=${term}&types=${state.advTypeFilter.join()}&book_fields=${state.bookSearchFields.join()}&topics=${topics.join()}&page=${
					state.page
				}`
			)
			.then((res: SearchResponse) => {
				const data = res?.data
				commit('setLastPage', data?.total.value)
				commit('setSearchResults', data)
				commit('setTotalResults', data?.total.value)
				commit('setTypeBuckets', data?.aggregations.types)
				commit('setTopicBuckets', data?.aggregations.topic)
				commit('setSubTopicBuckets', data?.aggregations.subtopic)
				commit('setTagBuckets', data?.aggregations.tags)
				commit('setAuthorBuckets', data?.aggregations.authors)
			})
	},
	updateSearchResults: async ({ commit, state }, term = '') => {
		term = term || state.searchTerm
		commit('setIsUpdating', true, { root: true })
		await api
			.getData(
				`/api/search?s=${term}&book_fields=${state.bookSearchFields.join()}&types=${state.typeFilter.join()}&authors=${state.authorFilter.join()}tags=${state.tagFilter.join()}&topics=${state.topicFilter.join()}&sub_topics=${state.subTopicFilter.join()}&page=${
					state.page
				}`
			)
			.then((res: SearchResponse) => {
				const data = res?.data
				commit('setLastPage', data?.total.value)
				commit('setSearchResults', data)
				commit('setTotalResults', data?.total.value)
				commit('updateTypeBuckets', data?.aggregations.types)
				commit('updateTopicBuckets', data?.aggregations.topic)
				commit('updateSubTopicBuckets', data?.aggregations.subtopic)
				commit('updateTagBuckets', data?.aggregations.tags)
				commit('updateAuthorBuckets', data?.aggregations.authors)
			})
	},
	retrieveNextResults: async ({ commit, state }, term = '') => {
		term = term || state.searchTerm
		const topics = state.advTopicFilter.map((a) => a.label)
		const response = await api
			.getData(
				`/api/search?s=${term}&types=${state.typeFilter.join()}&book_fields=${state.bookSearchFields.join()}&topics=${topics.join()}&sub_topics=${state.subTopicFilter.join()}&page=${state.page +
					1}`
			)
			.then((response: SearchResponse) => {
				commit('incrementPage', +1)
				commit('pushToSearchResults', response.data)
				return state.page < state.lastPage
			})
		return response
	}
}

const searchModule = {
	namespaced: true,
	state: new State(),
	mutations: mutations,
	getters: getters,
	actions: actions
}

export default searchModule
