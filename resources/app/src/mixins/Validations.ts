import { i18n } from '@/plugins/i18n-setup'
import { LocaleMessage } from 'vue-i18n'
import { Rules, RuleTypes } from '@/interfaces/Validation'
import { Error } from '@/interfaces/Error'

const Helpers: Rules = {
	// regex(val, param) {
	// 	return val.match(param) || 'Field must follow the pattern given'
	// },
	// url(val) {
	// 	console.log(val)
	// 	return true
	// },
	// email(val) {
	// 	const re = /\S+@\S+\.\S+/
	// 	return !val || re.test(val) || 'Field must be a valid email'
	// },
	// date(val) {
	// 	const regEx = /^\d{2}-\d{2}-\d{4}$/ // Only check format for now
	// 	return !val || !!val.match(regEx) || 'Field must be a valid date'
	// },
	// time(val) {
	// 	const regEx = /^\d{2}:\d{2}$/ // Only check format for now
	// 	return !val || !!val.match(regEx) || 'Field must be a valid time'
	// },
	// passwordConfirmation(val, param) {
	// 	return val === this.$store.getters[`${this.getLiveModule}/${param}`] || 'Fields do not match'
	// },
	// numeric(val) {
	// 	return !Number.isNaN(+val) || 'Field must be a valid number'
	// },
	// minNumeric(val, param) {
	// 	return !val || +val > +param || `Field must be more than ${param}`
	// },
	// maxNumeric(val, param) {
	// 	return !val || +val < +param || `Field must be less than ${param}`
	// },
	min(field: string, val: string, param: string): boolean | LocaleMessage {
		return (
			!val ||
			val.trim().length > +param ||
			i18n.t('errors.less_than', {
				field: i18n.t(field),
				chars: i18n.t(param)
			})
		)
	},
	max(field: string, val: string, param: string): boolean | LocaleMessage {
		return (
			!val ||
			val.trim().length < +param ||
			i18n.t('errors.more_than', {
				field: i18n.t(field),
				chars: i18n.t(param)
			})
		)
	},
	required(field: string, val: string, param: string): boolean | LocaleMessage {
		return (
			(val !== null && val.toString().trim() !== param) ||
			i18n.t('errors.required', {
				field: i18n.t(field)
			})
		)
	}
}

export default function useValidations(errors: Error) {
	function validate({ field, value, rules }: { field: string; value: string; rules: string[] }) {
		for (let i = rules.length - 1; i >= 0; i -= 1) {
			const rule = rules[i].split(':')
			const ruleType = rule[0] as RuleTypes
			const ruleParam = rule[1] || ''
			errors[field] = Helpers[ruleType](field, value, ruleParam)
			if (typeof errors[field] === 'string') {
				return false
			}
		}
		return true
	}

	return { validate }
}
