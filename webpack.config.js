const path = require('path');
const webpack = require('webpack')

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    plugins: [
        new webpack.DefinePlugin({
            _VUE_OPTIONS_API_: true,
            _VUE_PROD_DEVTOOLS_: true,
        }),
    ],
};