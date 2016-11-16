let path                 = require('path');
let webpack              = require('webpack');
let ExtractTextPlugin    = require("extract-text-webpack-plugin");
let BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const autoprefixerOptions = [
    'last 3 versions',
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
];

const vueLoaderConfig = {
    postcss : [
        require('autoprefixer')({
            browsers : autoprefixerOptions
        })
    ]
};

//let sassConfig = 'css-loader?sourceMap=inline!postcss-loader?sourceMap=inline!sass-loader?sourceMap=inline'

let sassConfig = ExtractTextPlugin.extract({
    loader         : 'css-loader!postcss-loader!sass-loader',
    fallbackLoader : 'vue-style-loader'
});

//if (process.env.NODE_ENV === 'production') {

vueLoaderConfig.loaders = {
    scss   : ExtractTextPlugin.extract({
        loader         : 'css-loader!sass-loader',
        fallbackLoader : 'vue-style-loader'
    }),
    sass   : ExtractTextPlugin.extract({
        loader         : 'css-loader!sass-loader',
        fallbackLoader : 'vue-style-loader'
    }),
    css    : ExtractTextPlugin.extract({
        loader         : 'css-loader',
        fallbackLoader : 'vue-style-loader'
    }),
    stylus : ExtractTextPlugin.extract({
        loader         : 'css-loader!stylus-loader',
        fallbackLoader : 'vue-style-loader'
    })
}

//}

// http://webpack.github.io/docs/configuration.html#devtool

module.exports = {
    // devtool : '#eval-source-map',
    devtool : '#source-map',

    entry   : {
        builder     : path.resolve(__dirname, './src/builder.js'),
        boilerplate : path.resolve(__dirname, './src/js/upb-boilerplate.js'),
        // preview     : path.resolve(__dirname, './src/js/upb-preview-script.js'),
        // skeleton    : path.resolve(__dirname, './src/js/upb-skeleton-script.js'),
        //// combined: ['./src/index.js', './src/index2.js']
    },
    output  : {
        path     : path.resolve(__dirname),
        filename : './assets/js/upb-[name].js'
    },
    module  : {
        rules : [
            {
                test    : /\.vue$/,
                loader  : 'vue-loader',
                options : vueLoaderConfig
            },
            {
                test    : /\.js$/,
                loader  : 'babel-loader',
                exclude : /node_modules/
            },
            {
                test    : /(\.sass|\.scss|\.css)$/,
                include : path.resolve(__dirname, './assets/scss'),
                loaders : sassConfig
            },
            {
                test    : /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader  : "url-loader",
                options : {
                    limit    : 10000,
                    minetype : 'application/font-woff',
                    name     : '../fonts/mdi/[name].[ext]?[hash:6]'
                }
            },
            {
                test    : /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader  : 'file-loader',
                options : {
                    limit : 10000,
                    name  : '../fonts/mdi/[name].[ext]?[hash:6]'
                }
            },

            {
                test    : /\.(png|jpg|gif|svg)$/,
                loader  : 'file-loader',
                options : {
                    limit : 10000,
                    name  : './assets/images/[name].[ext]?[hash:6]'
                }
            }
        ]
    },
    resolve : {
        alias : {
            'vue$' : 'vue/dist/vue'
        }
    },

    devServer : {
        historyApiFallback : true,
        noInfo             : true
    },

}

if (process.env.NODE_ENV === 'production') {

    module.exports.devtool = '#source-map';

    module.exports.output.filename = './assets/js/upb-[name].min.js';

    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.ProvidePlugin({
            'Vue'        : 'vue',
            'window.Vue' : 'vue',
        }),
        //new webpack.optimize.CommonsChunkPlugin({name : 'vue', filename : 'js/vue.min.js'}),
        new webpack.DefinePlugin({
            'process.env' : {
                NODE_ENV : '"production"'
            }
        }),

        new webpack.optimize.UglifyJsPlugin({
            sourceMap : true,
            compress  : {
                warnings : false
            }
        }),

        new webpack.LoaderOptionsPlugin({
            minimize : true
        }),

        new ExtractTextPlugin({
            filename : "./assets/css/upb-[name].min.css"
        }),

        //new ExtractTextPlugin("css/upb-style.min.css"),
    ])
}
else {
    module.exports.plugins = [
        new webpack.ProvidePlugin({
            'Vue'        : 'vue',
            'window.Vue' : 'vue',
        }),
        //new webpack.optimize.CommonsChunkPlugin({name : 'vue', filename : 'js/vue.js'}),
        new webpack.LoaderOptionsPlugin({
            minimize : false,
            debug    : true,
        }),
        // new BundleAnalyzerPlugin(), // to see state

        new ExtractTextPlugin({
            filename : "./assets/css/upb-[name].css"
        }),
    ]
}
