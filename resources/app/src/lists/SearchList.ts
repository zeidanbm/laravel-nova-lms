import { SelectOption } from '@/interfaces/Select'
import { i18n } from '@/plugins/i18n-setup'

export const topicsList: SelectOption[] = [
	{ label: i18n.t('Economey & Money'), value: 'economey_and_money', class: 'font-bold', isMarked: true },
	{ label: i18n.t('Politics & Law'), value: 'politics_and_law', class: 'font-bold', isMarked: true },
	{
		label: i18n.t('Language & Literature'),
		value: 'language_and_literature',
		class: 'font-bold',
		isMarked: true
	},
	{ label: i18n.t('History'), value: 'history', class: 'font-bold', isMarked: true },
	{ label: i18n.t('Social Sciences'), value: 'social_sciences', class: 'font-bold', isMarked: true },
	{ label: i18n.t('Diverse Topics'), value: 'diverse_topics', class: 'font-bold', isMarked: true }
]

export const bookFieldsList = [
	'title^10,title.text^8,title.stemmed^6',
	'sub_title^10,sub_title.text^6,sub_title.stemmed^4',
	'authors^10,authors.text^8',
	'tags^10,tags.text^4,tags.stemmed^2'
]

export const typeList = ['Book', 'Folder', 'Series', 'Periodic', 'Quote']
