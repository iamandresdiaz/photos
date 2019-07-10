let Encore = require('@symfony/webpack-encore');
const CompressionPlugin = require('compression-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/src/Photos/app.js')
    .addPlugin(
        new CompressionPlugin(
            {
                algorithm: 'gzip',
            }
        )
    )
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableReactPreset()

    .configureBabel((babelConfig) => {
        babelConfig.plugins = [
            "@babel/plugin-proposal-object-rest-spread",
            "@babel/plugin-proposal-class-properties",
            "@babel/plugin-transform-runtime",
            "babel-plugin-emotion"
        ]
    });

module.exports = Encore.getWebpackConfig();
