<template>
	<section class="flex flex-col justify-center items-center">
		<div class="px-4 pt-14 md:w-9/12 md:pt-24">
			<div class="w-full" :class="wrapperClass">
				<slot></slot>
				<Autocomplete @submit="handleSubmit" class="mb-2 max-w-3xl relative w-full">
					<LinkDefault
						class="inline-flex items-center mt-2 space-x-2 space-x-reverse"
						color="gray-100"
						@click="handleAdvancedSearchLinkClick"
					>
						<font-awesome-icon icon="plus" />
						<p>{{ $t('Advanced Search') }}</p>
					</LinkDefault>
				</Autocomplete>
			</div>
		</div>
		<AdvancedSearch v-if="getIsAdvancedSearchOpen" @cancel="handleCancel" @submit="handleSubmit" />
	</section>
</template>

<script>
import LinkDefault from './LinkDefault'
import Autocomplete from './Autocomplete'
import AdvancedSearch from '@/views/partials/AdvancedSearch/index.vue'
import { mapGetters, mapMutations, mapActions } from 'vuex'

export default {
	name: 'Hero',
	components: {
		LinkDefault,
		Autocomplete,
		AdvancedSearch
	},
	props: {
		title: {
			type: String,
			default: ''
		},
		link: {
			type: String,
			default: ''
		},
		wrapperClass: {
			type: String,
			default: ''
		}
	},
	data() {
		return {
			isOpen: false
		}
	},
	computed: {
		...mapGetters('SEARCH', ['getIsAdvancedSearchOpen', 'getSearchTerm'])
	},
	methods: {
		...mapMutations('SEARCH', ['setIsAdvancedSearchOpen', 'setIsSuggestionsOpen']),
		...mapActions('SEARCH', ['retrieveSearchResults']),
		handleAdvancedSearchLinkClick() {
			this.setIsAdvancedSearchOpen(true)
		},
		handleCancel() {
			this.setIsAdvancedSearchOpen(false)
		},
		handleSubmit() {
			this.setIsAdvancedSearchOpen(false)
			this.setIsSuggestionsOpen(false)
			/* eslint-disable-next-line @typescript-eslint/no-empty-function */
			this.$router
				.push({ name: 'Results', query: { q: this.getSearchTerm } })
				.then(() => {
					this.retrieveSearchResults(this.getSearchTerm)
				})
				.catch(() => {
					return true
				})
		}
	}
}
</script>
