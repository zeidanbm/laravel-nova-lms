export type Author = {
	id?: number
	name: string
	slug: string
}
export type Publisher = {
	id?: number
	name: string
	slug: string
}
export type Source = {
	id?: number
	name: string
	slug: string
}
export type Topic = {
	id?: number
	name: string
}
export type SubTopic = {
	id?: number
	name: string
}
export type Tag = {
	id?: number
	name: string
	slug: string
}
export type Img = {
	full: string
	large: string
	medium: string
	thumbnail: string
}
export type CoverImg = {
	id: number
	url: string
	details: Img
}
