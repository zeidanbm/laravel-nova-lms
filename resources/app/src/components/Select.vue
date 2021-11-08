<template>
	<div class="space-y-1">
		<label :id="`listbox-${name}`" class="block text-base leading-5 font-medium text-gray-900">{{ label }}</label>
		<div class="relative">
			<span class="inline-block w-full rounded-md shadow-sm">
				<button
					type="button"
					aria-haspopup="listbox"
					aria-expanded="true"
					:aria-labelledby="`listbox-${name}`"
					@click="isOpen = !isOpen"
					class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pr-3 pl-10 py-2 text-right focus:outline-none focus:shadow-outline-blue focus:border-blue-200 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
				>
					<span
						v-for="item in selected"
						:key="item.value"
						class="inline-flex items-center ml-1 mb-1.5 px-2 py-1 rounded text-xs font-medium leading-4 bg-blue-200 text-gray-900"
					>
						{{ item.label }}
					</span>
					<span v-show="!selected.length" class="block truncate">
						{{ $t(`select_${name}`) }}
					</span>
					<span class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
						<svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
							<path
								d="M7 7l3-3 3 3m0 6l-3 3-3-3"
								stroke-width="1.5"
								stroke-linecap="round"
								stroke-linejoin="round"
							/>
						</svg>
					</span>
				</button>
			</span>
			<div v-show="isOpen" class="absolute mt-1 mb-2 w-full rounded-md bg-white shadow-lg">
				<ul
					tabindex="-1"
					role="listbox"
					:aria-labelledby="`listbox-${name}`"
					aria-activedescendant="listbox-item-3"
					class="ich-scrollbar max-h-60 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5"
				>
					<li
						v-for="option in options"
						:key="option.value"
						:id="`listbox-${name}-${option.value}`"
						role="option"
						@click="handleSelect(option)"
						class="text-gray-900 hover:text-white hover:bg-blue-600 cursor-default select-none relative py-2 pr-3 pl-9"
					>
						<span :class="option.class" class="block truncate">
							{{ option.label }}
						</span>
						<span
							v-show="option.isMarked"
							class="text-blue-600 hover:text-white absolute inset-y-0 left-0 flex items-center pr-4"
						>
							<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
								<path
									fill-rule="evenodd"
									d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
									clip-rule="evenodd"
								/>
							</svg>
						</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
import Vue, { PropType } from 'vue'
import { SelectOption } from '@/interfaces/Select'

export default Vue.extend({
	name: 'Select',
	props: {
		label: {
			type: String,
			default: ''
		},
		name: {
			type: String,
			required: true
		},
		options: {
			type: Array as PropType<SelectOption[]>,
			required: true
		},
		selected: {
			type: Array as PropType<SelectOption[]>,
			default: []
		}
	},
	data() {
		return {
			isOpen: Boolean(false)
		}
	},
	methods: {
		handleSelect(option: SelectOption) {
			this.$emit('click', option)
		}
	},
	computed: {}
})
</script>
