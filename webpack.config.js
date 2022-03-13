const glob = require('glob');
const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');

const ThemeFrontendJs = glob.sync('./theme/src/js/*.js').reduce(function (obj, el) {
	obj['js/' + path.parse(el).name + '.min'] = el;
	obj['js/' + path.parse(el).name + '.bundle'] = el;
	return obj;
}, {});

const ThemeFrontendCSS = glob.sync('./theme/src/css/*.css').reduce(function (obj, el) {
	obj['css/' + path.parse(el).name] = el;
	return obj;
}, {});

const defaultConfig = {
	mode: 'production',
	optimization: {
		minimizer: [
			new TerserPlugin({
				include: /\.min\.js$/,
			}),
		],
	},
	resolve: {
		modules: ['node_modules'],
	},
    plugins: [
        new RemoveEmptyScriptsPlugin(),
        new MiniCssExtractPlugin({
            filename: "[name].css",
        }),
    ],
};

module.exports = [
    {
        ...defaultConfig,
        name: 'themeFrontend',
        entry: {
            ...ThemeFrontendJs,
            ...ThemeFrontendCSS,
        },
        output: {
            path: path.resolve(__dirname, 'theme/dist'),
            clean: true,
            filename: '[name].js',
        },
        module: {
            rules: [
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
                        }
                    ],
                },
            ]
        }
    }
]
