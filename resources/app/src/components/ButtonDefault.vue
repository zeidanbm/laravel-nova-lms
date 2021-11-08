<template>
	<span>
		<button
			:class="getCurrentClasses"
			@click.stop="$emit('click')"
			type="button"
			class="inline-flex items-center justify-center px-7 py-3 border text-base leading-6 rounded-sm focus:outline-none transition ease-in-out duration-150 w-full"
		>
			<slot></slot>
		</button>
	</span>
</template>

<script>
export default {
	name: 'ButtonDefault',
	props: {
		title: {
			type: String,
			default: ''
		},
		color: {
			type: String,
			default: 'bg-blue-700 text-gray-50 border-blue-700'
		},
		hover: {
			type: String,
			default: 'hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-600 hover:text-gray-50 active:text-gray-50'
		}
	},
	computed: {
		getCurrentClasses() {
			return `${this.color} ${this.hover}`
		}
	}
}
</script>
