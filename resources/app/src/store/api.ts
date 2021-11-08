import store from '@/store/index'
import { ServerResponse } from '@/interfaces/Response'

export const fetchController = new AbortController()
const signal = fetchController.signal

const configInit: RequestInit = {
	method: 'GET',
	headers: {
		'Content-Type': 'application/json',
		'Accept-Language': 'ar'
	},
	cache: 'no-cache',
	signal: signal
}

const apiFetch = async (args: RequestInfo): Promise<ServerResponse> => {
	return await window
		.fetch(args, configInit)
		.then((res) => res.json())
		.then((result) => {
			if (result.type === 'error') {
				throw Error(result.msg)
			}
			return result
		})
		.catch((e) => {
			if (e.name === 'AbortError') {
				throw 449
			}
			throw Error(e)
		})
		.finally(() => {
			store.commit('setIsLoading', false)
			store.commit('setIsUpdating', false)
		})
}

export const api = {
	async getData(url: string): Promise<ServerResponse> {
		// Default options are marked with *
		return apiFetch(url)
	},
	async postData(url: string, data: object = {}): Promise<ServerResponse> {
		// Default options are marked with *
		const response = await fetch(url, {
			method: 'POST', // *GET, POST, PUT, DELETE, etc.
			mode: 'cors', // no-cors, *cors, same-origin
			cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
			credentials: 'same-origin', // include, *same-origin, omit
			headers: {
				'Content-Type': 'application/json',
				'Accept-Language': 'ar'
				// 'Content-Type': 'application/x-www-form-urlencoded',
			},
			redirect: 'follow', // manual, *follow, error
			referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
			body: JSON.stringify(data) // body data type must match "Content-Type" header
		})
		return response.json() // parses JSON response into native JavaScript objects
	}
}
