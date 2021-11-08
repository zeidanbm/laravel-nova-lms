window.fetch = ((originalFetch) => {
	// eslint-disable-next-line no-shadow-restricted-names
	return (...arguments) => {
		const result = originalFetch.apply(this, arguments)
		return result.then(console.log('Request was sent'))
	}
})(fetch)
