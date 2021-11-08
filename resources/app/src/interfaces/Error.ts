import { LocaleMessage } from 'vue-i18n'

export interface Error {
	[index: string]: boolean | string | LocaleMessage
}
