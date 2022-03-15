const glob = require('glob');
const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
var LiveReloadPlugin = require('webpack-livereload-plugin');


/**
 * Gather the files to be bundled
 */

/**
 * Theme frontend JavaScript files
 *
 * @type {string[]}
 */
const ThemeFrontendJs = glob.sync('./theme/src/js/*.js').reduce(function (obj, el) {
	obj['js/' + path.parse(el).name + '.min'] = el;
	obj['js/' + path.parse(el).name + '.bundle'] = el;
	return obj;
}, {});

/**
 * Theme frontend CSS files
 *
 * @type {string[]}
 */
const ThemeFrontendCSS = glob.sync('./theme/src/css/*.css').reduce(function (obj, el) {
	obj['css/' + path.parse(el).name + '.min'] = el;
	return obj;
}, {});

/**
 * Theme frontend PHP files
 *
 * @type {string[]}
 */
const ThemePhp = glob.sync('./theme/**/*.php').reduce(function (obj, el) {
    obj['php/' + path.parse(el).name] = el;
    return obj;
}, {});


/**
 * Our default webpack config
 *
 * @type {Object}
 */
const defaultConfig = {
	mode: 'production',
	optimization: {
		minimizer: [
			new TerserPlugin({
				include: /\.min\.js$/,
			}),
		],
	},
    output: {
        path: path.resolve(__dirname, 'theme/dist'),
        clean: true,
        filename: '[name].js',
    },
	resolve: {
		modules: ['node_modules'],
	},
    plugins: [
        new LiveReloadPlugin({
            useSourceHash: true,
        }),
        new RemoveEmptyScriptsPlugin(),
        new MiniCssExtractPlugin({
            filename: "[name].css",
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
                loader: 'raw-loader',
            }
        ],
    },
};

module.exports = [
    {
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
            rules: [
                ...defaultConfig.module.rules,
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                        },
                    },
                },

            ]
        }
    }
]
