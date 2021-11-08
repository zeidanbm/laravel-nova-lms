import { LocaleMessage } from 'vue-i18n'

export interface Rules {
	min(field: string, val: string, param: string): boolean | LocaleMessage
	max(field: string, val: string, param: string): boolean | LocaleMessage
	required(field: string, val: string, param: string): boolean | LocaleMessage
}

export type RuleTypes = 'min' | 'max' | 'required'
