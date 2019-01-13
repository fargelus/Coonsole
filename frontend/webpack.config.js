const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../public/')
    .setPublicPath('/')
    .enableSingleRuntimeChunk()
    .addEntry('bundle', './test.js');

module.exports = Encore.getWebpackConfig();

