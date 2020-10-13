const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const isProduction = process.env.NODE_ENV === 'production';

const config = {
	// First, let's define an entry point for webpack to start its crawling.
	entry: './index.js',
	// Second, we define where the files webpack produce, are placed
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: 'bundle.js',
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
	plugins: [new MiniCssExtractPlugin()]
};

module.exports = config;