const postcssGlobalData = require('@csstools/postcss-global-data');

module.exports = {
	plugins: [
		['postcss-import'],
		postcssGlobalData({
			files: [
				'./theme/src/css/vars.css',
				'./theme/src/css/vars/_media-queries.css',
			],
		}),
		['postcss-custom-media'],
		['postcss-preset-env', { stage: 1 }],
		['cssnano'],
	],
};
