import { createLocalVue, mount } from '@vue/test-utils'
import searchModule from '@/store/modules/searchModule'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import { i18n } from '@/plugins/i18n-setup'
import Search from '@/components/Search.vue'

const router = new VueRouter()
const localVue = createLocalVue()
localVue.use(VueRouter)
localVue.use(Vuex)

const store = new Vuex.Store({
	modules: {
		SEARCH: searchModule
	}
})
// mocking fontAwesomeIcon components
const fontAwesomeIcon = () => {}

const factory = (values = {}, props = {}) => {
	return mount(Search, {
		localVue,
		router,
		store,
		i18n,
		components: {
			fontAwesomeIcon
		},
		data() {
			return {
				...values
			}
		},
		propsData: {
			...props
		}
	})
}

describe('Search.vue', () => {
	it('pressing enter submits the form if we have an input', async () => {
		const wrapper = factory()
		const input = wrapper.find('input[name="search"]')

		input.setValue('Foo')
		await input.trigger('keydown.enter')

		expect(wrapper.emitted().submit).toBeTruthy()
	})

	it('displays an error if input is only white spaces', async () => {
		const wrapper = factory({ hasErrors: false })
		const input = wrapper.find('input[name="search"]')

		input.setValue('   ')
		wrapper.vm.$store.commit('SEARCH/setSearchTerm', '   ')
		await input.trigger('keydown.enter')

		expect(wrapper.vm.$data.hasErrors).toBe(true)
		expect(wrapper.find('#search-error').text()).toHaveLength
	})

	it('displays an error if input is less than 3 characters', async () => {
		const wrapper = factory({ hasErrors: false })
		const input = wrapper.find('input[name="search"]')

		input.setValue('wt')
		wrapper.vm.$store.commit('SEARCH/setSearchTerm', '   ')
		await input.trigger('keydown.enter')

		expect(wrapper.vm.$data.hasErrors).toBe(true)
		expect(wrapper.find('#search-error').text()).toHaveLength
	})

	it('displays suggestions if input is more than 3 characters', async () => {
		const wrapper = factory({ hasErrors: false })
		const input = wrapper.find('input[name="search"]')

		input.setValue('الإمام')
		wrapper.vm.$store.commit('SEARCH/setSearchTerm', 'الإمام')
		await input.trigger('keydown.enter')

		expect(wrapper.vm.$store.getters['SEARCH/getSuggestions'].length).toBe(10)
	})

	// selecting a suggestion populates the input with suggestion title

	// selecting a suggestion triggers submit

	// can navigate with arrows the suggestions list

	//
})
