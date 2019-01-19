const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .setOutputPath('../public/')
    .setPublicPath('/')
    .addEntry('bundle', './ts/main.ts')
    .disableSingleRuntimeChunk()
    .addLoader({
        test: /\.styl$/,
        loader: 'vue-style-loader!css-loader!stylus-loader',
    })
    .addPlugin(
        new CopyWebpackPlugin([
            {
                from: 'assets/cities.json',
                to: 'data/',
            },
            {
                from: 'assets/images/static',
                to: 'images/[name].[ext]',
            },
        ]),
    )
    .enableVueLoader()
    .enableTypeScriptLoader((tsconfig) => {
        tsconfig.configFile = __dirname + '/tsconfig.json';
    });

module.exports = Encore.getWebpackConfig();

