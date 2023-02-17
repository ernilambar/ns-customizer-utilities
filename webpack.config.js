const path = require( 'path' );

const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
	...defaultConfig,
	entry: {
		controls: path.resolve( __dirname, 'resources', 'controls.js' ),
	},
	output: {
		path: path.resolve( __dirname, 'assets' ),
	},
};
