module.exports = {
    plugins: [
        [
            'postcss-import',
        ],
        [
            'postcss-preset-env',
            {
                stage: 1,
                features: {
                    'custom-media-queries': {
                        preserve: false,
                        importFrom: './theme/src/css/vars/_media-queries.css',
                    },
                    'custom-properties': {
                        preserve: true,
                        importFrom: './theme/src/css/vars.css',
                    },
                },
            }
        ],
        [
            'cssnano'
        ]
    ]
}
