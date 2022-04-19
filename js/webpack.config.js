const path = require('path')
const webpack = require('webpack')

module.exports = {
	mode: 'development',
	entry:{
		bundle: path.resolve(__dirname, 'src/index.js'),
	},
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: '[name].js'
	},
	resolve: {
        modules: [
            path.join(__dirname, "js"), "node_modules"
        ]
    },
	plugins:[
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery'
		}),
	]
}