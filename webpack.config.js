const path = require( 'path' );

const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );

module.exports = {
	target: 'browserslist',
	context: __dirname,
	entry: {
		controls: path.resolve( __dirname, 'resources', 'controls.js' ),
	},
	output: {
		path: path.resolve( __dirname, 'assets' ),
		filename: '[name].js',
		publicPath: './',
	},
	externals: {
		jquery: 'jQuery',
	},
	mode: 'development',
	devtool: 'inline-source-map',
	performance: {
		hints: false,
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
				options: {
					presets: [ [ '@babel/preset-env' ] ],
				},
			},
			{
				test: /\.css$/i,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					'postcss-loader',
				],
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf)$/,
				type: 'asset/resource',
				generator: {
					filename: 'fonts/[name][ext]',
				},
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif|webp)$/,
				type: 'asset/resource',
				generator: {
					filename: 'images/[name][ext]',
				},
			},
		],
	},
	plugins: [ new MiniCssExtractPlugin( { filename: '[name].css' } ) ],
	optimization: {
		minimizer: [
			new TerserPlugin( { extractComments: false } ),
			new CssMinimizerPlugin(),
		],
	},
};
