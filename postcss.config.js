module.exports = async function () {
	const { default: postcssGlobalData } = await import(
		'@csstools/postcss-global-data'
	);

	return {
		plugins: [
			['postcss-import'],
			[
				postcssGlobalData,
				{
					files: [
						'./theme/src/css/vars.css',
						'./theme/src/css/vars/_media-queries.css',
					],
				},
			],
			[
				'postcss-preset-env',
				{
					stage: 1,
				},
			],
			['cssnano'],
		],
	};
};
