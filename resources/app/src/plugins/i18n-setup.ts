import Vue from 'vue'
import VueI18n from 'vue-i18n'
import en from '../../../lang/vendor/nova/en.json'
import ar from '../../../lang/vendor/nova/ar.json'

Vue.use(VueI18n)

enum Locales {
	EN = 'en',
	AR = 'ar'
}

interface LOCALE {
	value: string
	name: string
	dir: string
}

const LOCALES: LOCALE[] = [
	{ value: Locales.EN, name: 'English', dir: 'ltr' },
	{ value: Locales.AR, name: 'العربية', dir: 'rtl' }
]

const messages = {
	[Locales.EN]: en,
	[Locales.AR]: ar
}

const defaultLocale = Locales.AR
const loadedLanguages = ['ar']

const i18n = new VueI18n({
	messages: messages,
	locale: defaultLocale,
	fallbackLocale: defaultLocale,
	silentTranslationWarn: true
})

function setI18nLanguage(lang: LOCALE) {
	i18n.locale = lang.value
	const html = document.querySelector<HTMLInputElement>('.html')
	if (html) {
		html.setAttribute('lang', lang.value)
		html.setAttribute('dir', lang.dir)
	}
	return lang
}

function loadLanguageAsync(lang: LOCALE) {
	// If the same language
	if (i18n.locale === lang.value) {
		return Promise.resolve(setI18nLanguage(lang))
	}

	// If the language was already loaded
	if (loadedLanguages.includes(lang.value)) {
		return Promise.resolve(setI18nLanguage(lang))
	}

	// If the language hasn't been loaded yet
	return import(/* webpackChunkName: "lang-[request]" */ `../../../lang/vendor/nova/${lang.value}.json`).then(
		(messages) => {
			i18n.setLocaleMessage(lang.value, messages.default)
			loadedLanguages.push(lang.value)
			return setI18nLanguage(lang)
		}
	)
}

export { LOCALES, i18n, loadLanguageAsync }
