import { SearchResult } from '@/interfaces/Search'

export type aggregations = {
	types: string
	topic: string
	subtopic: string
	tags: string
	authors: string
}

export type SearchData = {
	total: {
		relation: string
		value: number
	}
	results: Array<{
		_id: string
		_index: string
		_source: SearchResult
	}>
	aggregations: aggregations
}

type _Source = {
	model_id: number
	slug?: string
}
export type SuggestionOption = {
	text: string
	_id: string
	_index: string
	_score: number
	_type: string
	_source: _Source
}

export type AutocompleteData = {
	length: string
	offset: string
	options: SuggestionOption[]
	text: string
}

export interface ServerResponse {
	msg: string
	event: string
	status: string
}

export interface OwnedResponse extends ServerResponse {
	data?: string[]
}

export interface FeaturedResponse extends ServerResponse {
	data?: string[]
}

export interface BookResponse extends ServerResponse {
	data?: string[]
}

export interface AutocompleteResponse extends ServerResponse {
	data?: AutocompleteData
}

export interface SearchResponse extends ServerResponse {
	data?: SearchData
}
