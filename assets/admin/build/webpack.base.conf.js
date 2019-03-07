var webpack = require('webpack');
var path = require('path');
var autoprefixer = require('autoprefixer');
var chalk = require('chalk');
var ProgressBarPlugin = require('progress-bar-webpack-plugin');
// @see http://taobaofed.org/blog/2016/12/08/happypack-source-code-analysis/
var HappyPack = require('happypack');
var os = require('os');
var utils = require('./utils');
var vueLoaderConfig = require('./vue-loader.conf');
var config = require('../config');
const { VueLoaderPlugin } = require('vue-loader')

var happyThreadPool = HappyPack.ThreadPool({ size: os.cpus().length });

function resolve(dir) {
    return path.join(__dirname, '..', dir);
}

function createHappyPlugin(id, loaders) {
    return new HappyPack({
        id: id,
        loaders: loaders,
        threadPool: happyThreadPool,
        // make happy more verbose with HAPPY_VERBOSE=1
        verbose: process.env.HAPPY_VERBOSE === '1',
    });
}

module.exports = {
    entry: {
        app: ['babel-polyfill', './assets/admin/src/main.js'],
    },
    output: {
        path: config.build.assetsRoot,
        filename: '[name].js',
        publicPath: process.env.NODE_ENV === 'production' ? config.build.assetsPublicPath : config.dev.assetsPublicPath,
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        modules: [resolve('src'), resolve('/../../node_modules')],
        alias: {
            src: resolve('src'),
            partials: resolve('src/partials'),
            views: resolve('src/views'),
            assets: resolve('src/resolve'),
            locales: resolve('src/locales'),
            mixins: resolve('src/mixins'),
            helper: resolve('src/helper'),
            bootstrap: resolve('/../../node_modules/bootstrap'),
            components: resolve('src/components'),
            '@': resolve('src'),
        },
    },
    module: {
        noParse: /node_modules\/(iview\.js)/,
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: vueLoaderConfig,
                include: [resolve('src')],
                //exclude: /node_modules\/(?!(autotrack))|vendor\.dll\.js/,
            },
            {
                test: /\.scss$/,
                use: [
                    "style-loader", // creates style nodes from JS strings
                    "css-loader", // translates CSS into CommonJS
                    "sass-loader" // compiles Sass to CSS
                ]
            },
            {
                test: /\.js[x]?$/,
                include: [resolve('src')],
                exclude: [resolve('/../../node_modules')],
                loader: 'happypack/loader?id=happy-babel-js'
            },
            {
                test: /\.svg$/,
                loader: 'svg-sprite-loader',
                include: [resolve('src/icons')],
                options: {
                    symbolId: 'icon-[name]'
                }
            },
            {
                test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
                loader: 'url-loader',
                exclude: [resolve('src/icons')],
                query: {
                    limit: 10000,
                    name: utils.assetsPath('img/[name].[hash:7].[ext]'),
                },
            },
            {
                test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                loader: 'url-loader',
                query: {
                    limit: 10000,
                    name: utils.assetsPath('fonts/[name].[hash:7].[ext]'),
                },
            }
        ],
    },
    externals: {
        'babel-polyfill': 'window',
    },
    plugins: [
        new ProgressBarPlugin({
            format: '  build [:bar] ' + chalk.green.bold(':percent') + ' (:elapsed seconds)',
        }),
        new webpack.DllReferencePlugin({
            context: path.resolve(__dirname, '..'),
            manifest: require('./vendor-manifest.json'),
        }),
        new webpack.LoaderOptionsPlugin({
            options: {
                postcss: [
                    autoprefixer({
                        browsers: ['last 2 version'],
                    }),
                ],
            }
        }),
        createHappyPlugin('happy-babel-js', ['babel-loader?cacheDirectory=true']),
        createHappyPlugin('happy-babel-vue', ['babel-loader?cacheDirectory=true']),
        createHappyPlugin('happy-svg', ['svg-sprite-loader']),
        new HappyPack({
            loaders: [
                {
                    path: 'vue-loader',
                    query: {
                        loaders: {
                            scss: 'vue-style-loader!css-loader!sass-loader',
                            sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
                            js: 'happypack/loader?id=happy-babel-vue',
                        },
                    },
                },
            ],
        }),
        new webpack.ProvidePlugin({
            jQuery: 'jquery',
            $: 'jquery',
        })
    ],
};
