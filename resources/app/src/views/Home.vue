<template>
	<div class="flex-1">
		<Hero class="h-screen min-h-32 bg-hero" wrapper-class="md:max-w-lg">
			<h2 class="text-4xl text-gray-50">{{ $t('Al Imam Sharaf El Din') }}</h2>
			<p class="flex flex-col text-lg text-gray-100">
				{{ $t('hero_quote') }}
				<LinkDefault class="underline mt-2"> {{ $t('Read More') }}</LinkDefault>
			</p>
		</Hero>
	</div>
</template>

<script>
import Hero from '@/components/Hero.vue'
// import store from '@/store/index.ts'
import { mapMutations } from 'vuex'
// function beforeRoute(to, from, next) {
// 	store.dispatch('HOME/retrieveOwnedPublications').then(next())
// }

export default {
	name: 'Home',
	components: {
		Hero
	},
	created() {
		this.setSearchTerm('')
	},
	methods: {
		...mapMutations('SEARCH', ['setSearchTerm'])
	}
	// beforeRouteEnter(to, from, next) {
	// 	beforeRoute(to, from, next)
	// }
}
</script>
