<template>
	<div>
		<div class="relative rounded-sm shadow-lg mt-12" id="search">
			<div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
				<font-awesome-icon icon="search" size="lg" class="text-gray-400" />
			</div>
			<input
				name="search"
				v-model="searchTerm"
				v-click-outside="handleClickOutside"
				:placeholder="$t('I want to search for...')"
				autocomplete="off"
				class="form-input block w-full pt-2 pr-11 pl-2 leading-5 h-14 rounded-sm"
				aria-label="Search"
				aria-invalid="true"
				aria-describedby="search-error"
				@focus="handleClickInside"
				@keydown.down="onArrowDown"
				@keydown.up="onArrowUp"
				@keydown.enter="onEnter"
			/>
		</div>
		<div v-show="getIsSuggestionsOpen" class="absolute mt-2 w-full rounded-md bg-white shadow-lg">
			<ul
				tabindex="-1"
				role="listbox"
				:aria-labelledby="`listbox-suggestions`"
				aria-activedescendant="listbox-item-3"
				class="ich-scrollbar w-full max-h-60 rounded-md shadow-xs overflow-auto focus:outline-none"
			>
				<li
					v-for="(suggestion, index) in getSuggestions"
					:key="index"
					:id="`listbox-suggestions-${index}`"
					role="option"
					@click="handleOptionClick(suggestion)"
					:class="{ 'bg-gray-200': index === arrowCounter }"
					class="hover:bg-gray-100 active:bg-gray-200 focus:outline-none focus:bg-gray-200 transition duration-150 ease-in-out cursor-pointer select-none relative py-1 pr-3 pl-9 border-t first:border-t-0 border-gray-200"
				>
					<span class="text-sm leading-5 font-medium text-gray-800">{{ suggestion }}</span>
				</li>
			</ul>
		</div>
		<p v-show="errors.search != true" class="pt-2 text-sm text-red-600" id="search-error">{{ errors.search }}</p>
		<slot></slot>
	</div>
</template>

<script lang="ts">
import { defineComponent, reactive, computed, toRefs } from '@vue/composition-api'
import { DebouncedFunc } from 'lodash'
import { clickOutside } from '@/plugins/v-click-outside'
import useValidations from '@/mixins/Validations'
import { Error } from '@/interfaces/Error'
import debounce from 'lodash/debounce'

export default defineComponent({
	name: 'Autocomplete',
	setup(props, { emit, root: { $store } }) {
		let debouncedSuggestions: DebouncedFunc<() => void>
		const retrieveSuggestions = function() {
			$store.dispatch('SEARCH/retrieveSuggestions').then(() => {
				$store.commit('SEARCH/setIsSuggestionsOpen', true)
			})
		}
		const event = reactive({
			errors: {
				search: true
			},
			arrowCounter: -1,
			searchTerm: computed({
				get(): string {
					return $store.getters['SEARCH/getSearchTerm']
				},
				set: function(value: string) {
					$store.commit('SEARCH/setSearchTerm', value)
					if (value.trim().length < 3) {
						return $store.commit('SEARCH/resetSuggestions')
					}
					debouncedSuggestions = debounce(retrieveSuggestions, 300)
					debouncedSuggestions()
				}
			}),
			getTotalSuggestions: computed(() => $store.getters['SEARCH/getTotalSuggestions']),
			getSuggestions: computed((): string[] => $store.getters['SEARCH/getSuggestions']),
			getIsSuggestionsOpen: computed((): string => $store.getters['SEARCH/getIsSuggestionsOpen'])
		})

		const { validate } = useValidations(event.errors as Error)

		function submit() {
			$store.commit('SEARCH/resetAdvancedSearch')
			emit('submit')
		}

		function onEnter(e: KeyboardEvent): void {
			e.preventDefault()
			if (typeof debouncedSuggestions !== 'undefined') {
				debouncedSuggestions.cancel()
			}

			const el = e.currentTarget as HTMLInputElement

			if (
				validate({
					field: 'search',
					value: el.value,
					rules: ['required', 'min:3']
				})
			) {
				submit()
			}
		}

		function handleOptionClick(option: string) {
			$store.commit('SEARCH/setSearchTerm', option)
			submit()
		}
		function onArrowDown(): void {
			if (event.arrowCounter < event.getTotalSuggestions) {
				event.arrowCounter += 1
				$store.commit('SEARCH/setSearchTermAsSuggestion', event.arrowCounter)
			}
		}
		function onArrowUp(): void {
			if (event.arrowCounter > 0) {
				event.arrowCounter -= 1
				$store.commit('SEARCH/setSearchTermAsSuggestion', event.arrowCounter)
			}
		}
		function handleClickInside(): void {
			if (!event.getIsSuggestionsOpen) {
				$store.commit('SEARCH/setIsSuggestionsOpen', true)
			}
		}
		function handleClickOutside(): void {
			if (event.getIsSuggestionsOpen) {
				$store.commit('SEARCH/setIsSuggestionsOpen', false)
			}
		}

		return {
			...toRefs(event),
			onEnter,
			handleOptionClick,
			onArrowUp,
			onArrowDown,
			handleClickOutside,
			handleClickInside
		}
	},
	directives: {
		clickOutside
	}
})
</script>
