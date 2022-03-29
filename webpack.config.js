/**
 * External dependencies
 */
const glob = require('glob');
const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const LiveReloadPlugin = require('webpack-livereload-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const chokidar = require('chokidar');

/**
 * Theme frontend JavaScript files
 *
 * @type {string[]}
 */
const ThemeFrontendJs = glob
	.sync('./theme/src/js/*.js')
	.reduce(function (obj, el) {
		obj['js/' + path.parse(el).name + '.min'] = el;
		obj['js/' + path.parse(el).name + '.bundle'] = el;
		return obj;
	}, {});

/**
 * Theme frontend CSS files
 *
 * @type {string[]}
 */
const ThemeFrontendCSS = glob
	.sync('./theme/src/css/*.css')
	.reduce(function (obj, el) {
		obj['css/' + path.parse(el).name + '.min'] = el;
		return obj;
	}, {});

/**
 * Theme backend JavaScript files
 *
 * @type {string[]}
 */
const ThemeBackendJs = glob
	.sync('./theme/admin/src/js/*.js')
	.reduce(function (obj, el) {
		obj['js/' + path.parse(el).name + '.min'] = el;
		obj['js/' + path.parse(el).name + '.bundle'] = el;
		return obj;
	}, {});

/**
 * Theme backend CSS files
 *
 * @type {string[]}
 */
const ThemeBackendCSS = glob
	.sync('./theme/admin/src/css/*.css')
	.reduce(function (obj, el) {
		obj['css/' + path.parse(el).name + '.min'] = el;
		return obj;
	}, {});

/**
 * Theme PHP files
 *
 * @type {string[]}
 */
const ThemePhp = glob.sync('./theme/**/*.php').reduce(function (obj, el) {
	obj['php/' + path.parse(el).name] = el;
	return obj;
}, {});

/**
 * Plugin backend JavaScript files
 *
 * @type {string[]}
 */
const PluginBackendJs = glob
	.sync('./plugin/admin/src/js/*.js')
	.reduce(function (obj, el) {
		obj['js/' + path.parse(el).name + '.min'] = el;
		obj['js/' + path.parse(el).name + '.bundle'] = el;
		return obj;
	}, {});

/**
 * Plugin backend CSS files
 *
 * @type {string[]}
 */
const PluginBackendCSS = glob
	.sync('./plugin/admin/src/css/*.css')
	.reduce(function (obj, el) {
		obj['css/' + path.parse(el).name + '.min'] = el;
		return obj;
	}, {});

/**
 * The default JS loader.
 * This is a very vanilla JS loader based on Babel preset-env.
 *
 * @type {Object}
 */
const defaultJsLoader = {
	test: /\.js$/,
	exclude: /node_modules/,
	use: {
		loader: 'babel-loader',
		options: {
			presets: ['@babel/preset-env'],
		},
	},
};

/**
 * The WordPress JS loader.
 * The opinionated WordPress JS loader. We only use this within the WordPress admin.
 *
 * @type {Object}
 */
const wordpressJsLoader = {
	test: /\.js$/,
	exclude: /node_modules/,
	use: {
		loader: 'babel-loader',
		options: {
			presets: ['@wordpress/babel-preset-default'],
			plugins: [
				'@wordpress/babel-plugin-import-jsx-pragma',
				'@babel/plugin-transform-react-jsx',
				'lodash',
			],
		},
	},
};

/**
 * Get a file watcher.
 *
 * @param {Array} files Array of files.
 */
const createFileWatcher = (files) => {
	const watcher = chokidar.watch(files, {
		ignored: ['node_modules', 'vendor'],
		ignoreInitial: true,
		followSymlinks: false,
		atomic: false,
	});
	return watcher;
};

/**
 * Live Reloading
 *
 * @param {Object} options The options to use with LiveReload.
 */
const initLiveReloadPlugin = (options = {}) => {
	const _options = {
		...options,
		appendScriptTag: true,
	};
	const liveReloadPlugin = new LiveReloadPlugin(_options);
	const reload = () => {
		// this goes through to tiny-lr that is being used by LiveReloadPlugin
		liveReloadPlugin.server.notifyClients(['index.php']);
	};
	// watch for changes to .php files and reload
	createFileWatcher('**/**.php').on('change', reload).on('unlink', reload)

	return liveReloadPlugin;
};

/**
 * Our default webpack config
 *
 * @type {Object}
 */
const defaultConfig = {
	mode: 'development',
	optimization: {
		minimizer: [
			new TerserPlugin({
				include: /\.min\.js$/,
			}),
		],
	},
	output: {
		clean: true,
		filename: '[name].js',
	},
	resolve: {
		modules: ['node_modules'],
	},
	plugins: [
		initLiveReloadPlugin({
			useSourceHash: true,
		}),
		new RemoveEmptyScriptsPlugin({
			extensions: ['css', 'php'],
		}),
		new MiniCssExtractPlugin({
			filename: '[name].css',
		}),
	],
	module: {
		rules: [
			{
				test: /\.css$/i,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							modules: false,
							import: false,
							url: false,
							sourceMap: true,
							importLoaders: 1,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
						},
					},
				],
			},
			{
				test: /\.php$/,
				loader: 'null-loader',
			},
		],
	},
};

/**
 * The webpack config to bundle CSS and JS for the Theme frontend.
 *
 * @type {Object}
 */
const themeFrontendWebpackOptions = {
	...defaultConfig,
	name: 'themeFrontend',
	entry: {
		...ThemeFrontendJs,
		...ThemeFrontendCSS,
		...ThemePhp,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(__dirname, 'theme/dist'),
	},
	module: {
		rules: [...defaultConfig.module.rules, defaultJsLoader],
	},
};

/**
 * The webpack config to bundle CSS and JS for the Theme backend.
 *
 * @type {Object}
 */
const themeBackendWebpackOptions = {
	...defaultConfig,
	name: 'themeBackend',
	entry: {
		...ThemeBackendJs,
		...ThemeBackendCSS,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(__dirname, 'theme/admin/dist'),
	},
	module: {
		rules: [...defaultConfig.module.rules, wordpressJsLoader],
	},
	plugins: [
		...defaultConfig.plugins,
		new DependencyExtractionWebpackPlugin({
			outputFormat: 'json',
			combineAssets: true,
		}),
	],
};

/**
 * The webpack config to bundle CSS and JS for the Plugin backend.
 *
 * @type {Object}
 */
const pluginBackendWebpackOptions = {
	...defaultConfig,
	name: 'pluginBackend',
	entry: {
		...PluginBackendJs,
		...PluginBackendCSS,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(__dirname, 'plugin/admin/dist'),
	},
	module: {
		rules: [...defaultConfig.module.rules, wordpressJsLoader],
	},
	plugins: [
		...defaultConfig.plugins,
		new DependencyExtractionWebpackPlugin({
			outputFormat: 'json',
			combineAssets: true,
		}),
	],
};

module.exports = [
	themeFrontendWebpackOptions,
	pluginBackendWebpackOptions,
	themeBackendWebpackOptions,
];
