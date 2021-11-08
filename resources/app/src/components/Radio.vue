<template>
	<div class="flex items-center">
		<input
			:id="getName"
			:name="getName"
			:value="getName"
			v-model="value"
			@click="$emit('click', value)"
			type="radio"
			class="form-radio h-4 w-4 text-blue-700 transition duration-150 ease-in-out"
		/>
		<label :for="getName" class="mr-3">
			<span class="block text-sm leading-5 font-medium text-gray-700">{{ label }}</span>
		</label>
	</div>
</template>

<script>
import snakeCase from 'lodash/snakeCase'

export default {
	name: 'Radio',
	props: {
		label: {
			type: String,
			default: ''
		}
	},
	data() {
		return {
			value: ''
		}
	},
	computed: {
		getName() {
			return snakeCase(this.label)
		}
	}
}
</script>
