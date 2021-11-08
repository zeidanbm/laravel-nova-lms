const { keyBy } = require('lodash')
const chokidar = require('chokidar')
const path = require('path')
require('dotenv').config({ path: path.resolve(__dirname, '../../.env') })
const WebpackAssetsManifest = require('webpack-assets-manifest')

const manifest = new WebpackAssetsManifest({
	output: 'mix-manifest.json',
	transform(assets, manifest) {
		for (key in assets) {
			assets['/' + key] = assets[key]
			delete assets[key]
		}
		return assets
	}
})

module.exports = {
	devServer: {
		before(app, server) {
			chokidar.watch(['../views/**/*.blade.php']).on('all', function() {
				server.sockWrite(server.sockets, 'content-changed')
			})
		},
		index: '',
		contentBase: './dist',
		historyApiFallback: true,
		compress: true,
		overlay: true,
		port: 3000,
		open: true,
		hot: true,
		host: 'localhost',
		proxy: `${process.env.APP_URL}:${process.env.APP_PORT}`,
		public: `${process.env.APP_URL_ALIAS}:${process.env.APP_PORT}`,
		headers: {
			'Access-Control-Allow-Origin': '*',
			'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Accept'
		},
		watchOptions: {
			aggregateTimeout: 300,
			poll: 1000
		},
		writeToDisk: true
	},
	publicPath: '/',
	outputDir: '../../public/',
	// modify the location of the generated HTML file.
	indexPath: process.env.NODE_ENV === 'production' ? './views/default.blade.php' : 'index.blade.php',
	productionSourceMap: false,
	filenameHashing: true,
	configureWebpack: {
		plugins: [manifest]
	},
	pluginOptions: {
		i18n: {
			locale: 'ar',
			fallbackLocale: 'ar',
			localeDir: 'locales',
			enableInSFC: true
		}
	},
	chainWebpack: (config) => {
		config.resolve.alias.set('@', path.resolve(__dirname, 'src'))
		config.resolve.alias.set('@imgs', path.resolve(__dirname, 'src/assets'))

		config.module
			.rule('images')
			.use('url-loader')
			.loader('url-loader')
			.tap((options) => Object.assign(options, { limit: 10240 }))

		const svgRule = config.module.rule('svg')

		svgRule.uses.clear()

		svgRule
			.use('babel-loader')
			.loader('babel-loader')
			.end()
			.use('vue-svg-loader')
			.loader('vue-svg-loader')
	}
}
