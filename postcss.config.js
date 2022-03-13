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
                    },
                    'custom-properties': {
                        preserve: true,
                    },
                },
            }
        ],
        [
            'cssnano'
        ]
    ]
}
