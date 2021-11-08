import { TranslateResult } from 'vue-i18n'

export interface SelectOption {
	label: TranslateResult
	value: string
	class: string
	isMarked: boolean
}
