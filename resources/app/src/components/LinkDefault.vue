<template>
	<a
		:to="link"
		:class="getCurrentClasses"
		@click.stop="$emit('click')"
		class="whitespace-no-wrap text-lg leading-6 font-medium focus:outline-none cursor-pointer"
	>
		<slot></slot>
	</a>
</template>

<script>
export default {
	name: 'LinkDefault',
	props: {
		link: {
			type: String,
			default: '#'
		},
		color: {
			type: String,
			default: 'gray-50'
		},
		hover: {
			type: String,
			default: 'blue-400'
		}
	},
	computed: {
		getCurrentClasses() {
			return `text-${this.color} hover:text-${this.hover} 
			focus:text-${this.hover}`
		}
	}
}
</script>
