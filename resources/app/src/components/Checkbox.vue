<template>
	<div class="flex items-start">
		<div class="flex items-center h-5">
			<input
				v-model="inputVal"
				v-bind="$attrs"
				:value="$attrs.name"
				:id="$attrs.name"
				type="checkbox"
				class="form-checkbox h-4 w-4 text-blue-700 border-gray-400 cursor-pointer transition duration-150 ease-in-out"
			/>
		</div>
		<div class="mr-3 text-sm leading-5">
			<label :for="$attrs.name" class="font-medium text-gray-600 cursor-pointer hover:text-gray-400">
				{{ label }}
				<slot />
			</label>
			<p class="text-gray-400">{{ hint }}</p>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Checkbox',
	inheritAttrs: false,
	props: {
		label: {
			type: String,
			default: ''
		},
		hint: {
			type: String,
			default: ''
		},
		value: {
			type: [String, Array],
			default: ''
		}
	},
	computed: {
		inputVal: {
			get() {
				return this.value
			},
			set(val) {
				this.$emit('input', val)
			}
		}
	}
}
</script>
