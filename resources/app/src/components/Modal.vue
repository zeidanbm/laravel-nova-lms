<template>
	<transition
		enter-active-class="transition ease-out duration-300"
		enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
		enter-to-class="opacity-100 translate-y-0 sm:scale-100"
		leave-active-class="transition ease-in duration-200"
		leave-class="opacity-100 translate-y-0 sm:scale-100"
		leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
	>
		<div
			class="fixed bottom-0 inset-x-0 px-4 pb-6 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center z-50"
		>
			<div class="fixed inset-0 transition-opacity">
				<div class="absolute inset-0 bg-gray-500 opacity-75"></div>
			</div>

			<div
				class="bg-white rounded-lg px-4 pt-5 pb-4 ich-scrollbar overflow-hidden overflow-y-auto shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6"
				role="dialog"
				aria-modal="true"
				aria-labelledby="modal-headline"
			>
				<div class="mt-3 sm:mt-5">
					<slot name="header"></slot>
					<slot></slot>
				</div>
				<div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
					<slot name="footer"></slot>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
export default {
	name: 'Modal',
	props: {
		headline: {
			type: String,
			default: ''
		},
		okay: {
			type: String,
			default: 'Okay'
		},
		cancel: {
			type: String,
			default: 'Cancel'
		}
	},
	methods: {
		okayButtonClicked() {
			this.$emit('okay')
		},
		cancelButtonClicked() {
			this.$emit('cancel')
		}
	}
}
</script>
