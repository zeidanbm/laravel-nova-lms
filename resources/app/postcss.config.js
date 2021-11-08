const autoprefixer = require('autoprefixer')
const tailwindcss = require('tailwindcss')
const cssnano = require('cssnano')

module.exports = {
	plugins: [
		tailwindcss,
		autoprefixer,
		process.env.NODE_ENV === 'production' ? cssnano({ preset: 'default' }) : null
		// purgecss({
		// 	content: [
		// 		'./index.php',
		// 		'./resources/assets/scripts/**/*.vue',
		// 		'./resources/assets/views/**/*.blade.php',
		// 		'./resources/assets/scripts/**/**/*.vue'
		// 	],
		// whitelistPatterns: [/^.[^\.]*\.[^\. "']*/]
		// defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || []
		// })
	]
}
