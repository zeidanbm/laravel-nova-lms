import router from '@/router'
// import { loadLanguageAsync } from './i18n-setup'

router.beforeEach((_to, _from, next) => {
	next()
	// const lang = to.params.lang
	// console.log(lang)
	// loadLanguageAsync(lang).then(() => next())
})

export default router
