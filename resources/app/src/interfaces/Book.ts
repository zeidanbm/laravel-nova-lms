export interface Book {
	id: number
	title: string
	sub_title: string | null
	slug: string
	type: string
	topic: string
	subtopic: string
	body: string | null
	authors: string[]
	cover_thumbnail: string
	cover_medium: string
	cover_large: string
	tags: string[]
	publishers: string[]
	source: string[]
}
