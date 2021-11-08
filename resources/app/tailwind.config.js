module.exports = {
	purge: {
		mode: 'all',
		content: [
			'./index.php',
			'./src/**/*.vue',
			'../views/**/*.blade.php',
			'./src/**/**/*.vue',
			'./src/**/**/**/*.vue'
		]
	},
	theme: {
		extend: {
			screens: {
				sm: '480px',
				md: '768px',
				lg: '992px',
				xl: '1280px'
			},
			colors: {
				primary: {
					dark: '#0e316d',
					default: '#2351a1',
					light: '#4397d4'
				}
			},
			lineHeight: {
				'extra-loose': '2.5',
				'12': '3rem'
			},
			zIndex: {
				'-10': '-10'
			},
			height: {
				'40vh': '40vh'
			},
			minHeight: {
				'24': '24rem',
				'32': '32rem'
			},
			maxWidth: {
				'8xl': '90rem'
			},
			gridTemplateColumns: {
				// Complex site-specific column configuration
				card2sm: 'repeat(2, minmax(0, 140px))',
				card3sm: 'repeat(3, minmax(0, 140px))',
				card4sm: 'repeat(4, minmax(0, 140px))',
				card3md: 'repeat(3, minmax(0, 210px))',
				card4md: 'repeat(4, minmax(0, 210px))',
				card5md: 'repeat(5, minmax(0, 210px))',
				filtermd: 'minmax(auto, 30%) 1fr',
				filterlg: 'minmax(15%, 290px) repeat(3, 1fr)'
			}
		}
	},
	variants: {
		borderWidth: ['responsive', 'first', 'hover', 'focus']
	},
	plugins: [
		require('tailwindcss-debug-screens'),
		require('./src/plugins/tailwind-justify-items'),
		require('@tailwindcss/ui')
	]
}
