import { Topic, SubTopic, Publisher, Source, Author, Tag, Img } from '@/interfaces/Catalog'

export type SearchResult = {
	model_id: string
	type: string
	title: string
	sub_title?: string
	serires_title?: string
	topic?: Topic
	subtopic?: SubTopic
	authors: Author[]
	cover: Img
	tags?: Tag[]
	formate: string
	publishers: Publisher[]
	source: Source[]
	link: string
}

export interface Bucket {
	doc_count: number
	key: string
}
