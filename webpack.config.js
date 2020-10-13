const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
	// First, let's define an entry point for webpack to start its crawling.
	entry: './index.js',
	// Second, we define where the files webpack produce, are placed
	output: {
		path: path.resolve(__dirname, 'public'),
		filename: 'assets/js/bundle.js',
	},
	module: {
		rules: [
			{
				test: /\.less$/, // .less and .css
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					'less-loader'
				],
			},
		]
	},
	// Add an instance of the MiniCssExtractPlugin to the plugins list
	// But remember - only for production!
	plugins: [new MiniCssExtractPlugin(
		{
			filename: 'assets/css/style.css'
		}
	)]
};