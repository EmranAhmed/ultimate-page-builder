var path    = require('path')
var webpack = require('webpack')

module.exports = {
    entry         : './src/main.js',
    output        : {
        path     : path.resolve(__dirname, './assets/js'),
        //publicPath : '/assets/js/',
        filename : 'upb-customizer-preview.min.js'
    },
    resolveLoader : {
        root : path.join(__dirname, 'node_modules'),
    },
    module        : {
        loaders : [
            {
                test   : /\.vue$/,
                loader : 'vue'
            },
            {
                test    : /\.js$/,
                loader  : 'babel',
                exclude : /node_modules/
            },
            {
                test   : /\.(png|jpg|gif|svg)$/,
                loader : 'file',
                query  : {
                    name : '[name].[ext]?[hash]'
                }
            },
            {
                test    : /\.scss$/,
                loaders : ["style", "css", "sass"]
            }
        ]
    },
    sassLoader    : {
        includePaths : [path.resolve(__dirname, './assets/scss')]
    },
    devServer     : {
        historyApiFallback : true,
        noInfo             : true
    },
    devtool       : '#eval-source-map'
}

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map'
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
        })
    ])
}
