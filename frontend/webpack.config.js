const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../public/')
    .setPublicPath('/')
    .addEntry('bundle', './ts/main.ts')
    .disableSingleRuntimeChunk()
    .addLoader({
        test: /\.styl$/,
        loader: 'vue-style-loader!css-loader!stylus-loader',
    })
    .enableVueLoader()
    .enableTypeScriptLoader((tsconfig) => {
        tsconfig.configFile = __dirname + '/tsconfig.json';
    });

module.exports = Encore.getWebpackConfig();

