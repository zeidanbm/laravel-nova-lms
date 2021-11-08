/* eslint-disable @typescript-eslint/no-var-requires */
const _ = require('lodash')
const plugin = require('tailwindcss/plugin')

module.exports = plugin(function({ addUtilities, e }) {
	const justify = ['start', 'center', 'end', 'baseline']
	const justifyVariants = ['responsive']

	const utilities = _.map(justify, (alignment) => ({
		[`.justify-items-${e(alignment)}`]: {
			'justify-items': alignment
		}
	}))

	addUtilities(utilities, justifyVariants)
})
