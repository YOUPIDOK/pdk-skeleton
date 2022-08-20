const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/admin')
    .setPublicPath('/build/admin')
    .addEntry('admin', './assets/admin/app.js')
    .enableStimulusBridge('./assets/admin/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(true)
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader();

if (Encore.isProduction()) {
    Encore.copyFiles({
        from: './assets/admin/images',
        to: 'images/[path][name].[hash:8].[ext]',
        pattern: /\.(png|jpg|jpeg|gif|ico|svg|webp)$/
    });
} else {
    Encore.copyFiles({
        from: './assets/admin/images',
        to: 'images/[path][name].[hash:8].[ext]',
        pattern: /\.(png|jpg|jpeg|gif|ico|svg|webp)$/
    });
}

module.exports = Encore.getWebpackConfig();
