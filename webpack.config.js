var path              = require('path')
var webpack           = require('webpack')
var ExtractTextPlugin = require("extract-text-webpack-plugin")
var autoprefixer      = require('autoprefixer')

module.exports = {
    entry     : './src/main.js',
    output    : {
        path       : path.resolve(__dirname, './assets/js'),
        publicPath : '/assets/js/',
        filename   : 'upb-build.js'
    },
    module    : {
        rules : [
            {
                test    : /\.vue$/,
                loader  : 'vue',
                options : {
                    // vue-loader options go here
                    loaders : {
                       // scss : ExtractTextPlugin.extract({
                       //     loader : 'css?sourceMap!sass?sourceMap'
                       // }),
                       // sass : ExtractTextPlugin.extract({
                       //     loader : 'css?sourceMap!sass?sourceMap'
                       // }),
                       // css  : ExtractTextPlugin.extract({
                       //     loader : 'css?sourceMap'
                       // }),

                    }
                }
            },
            {
                test    : /\.js$/,
                loader  : 'babel',
                exclude : /node_modules/
            },
            {
                test    : /\.(png|jpg|gif|svg)$/,
                loader  : 'file',
                options : {
                    name : '[name].[ext]?[hash]'
                }
            }
        ]
    },
    resolve   : {
        alias : {
            'vue$' : 'vue/dist/vue'
        }
    },
    devServer : {
        historyApiFallback : true,
        noInfo             : true
    }
}

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = 'source-map';
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            'process.env' : {
                NODE_ENV : '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress : {
                warnings : false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize : true,
            vue      : {
                // use custom postcss plugins
                postcss : [autoprefixer({
                    browsers : [
                        'last 2 version',
                        '> 1%',
                        'ie >= 9',
                        'ie_mob >= 10',
                        'ff >= 30',
                        'chrome >= 34',
                        'safari >= 7',
                        'opera >= 23',
                        'ios >= 7',
                        'android >= 4',
                        'bb >= 10'
                    ]
                })]
            }
        }),
        //new ExtractTextPlugin("../css/upb-style.min.css")
    ])
}
else {
    module.exports.devtool = 'inline-source-map';
    module.exports.plugins = [
        new webpack.LoaderOptionsPlugin({
            debug : true,
            vue   : {
                // use custom postcss plugins
                postcss : [autoprefixer({
                    browsers : [
                        'last 2 version',
                        '> 1%',
                        'ie >= 9',
                        'ie_mob >= 10',
                        'ff >= 30',
                        'chrome >= 34',
                        'safari >= 7',
                        'opera >= 23',
                        'ios >= 7',
                        'android >= 4',
                        'bb >= 10'
                    ]
                })]
            }
        }),
        //new ExtractTextPlugin("../css/upb-style.css")
    ]
}
