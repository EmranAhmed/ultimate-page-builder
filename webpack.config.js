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

if (process.env.NODE_ENV === 'production') {
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
}
else {
    vueLoaderConfig.loaders = {
        scss    : 'vue-style-loader!css-loader!sass-loader',
        sass    : 'vue-style-loader!css-loader!sass-loader',
        css     : 'vue-style-loader!css-loader',
        stylus  : 'vue-style-loader!css-loader!stylus-loader',
        exclude : path.resolve(__dirname, 'node_modules')
    }
}

// http://webpack.github.io/docs/configuration.html#devtool

module.exports = {
    devtool   : '#eval-source-map',
    entry     : {
        builder : path.resolve(__dirname, './src/builder.js'),
    },
    output    : {
        path       : path.resolve(__dirname, './assets'),
        publicPath : '/assets/',
        filename   : 'js/upb-[name].js'
    },
    externals : {
        jquery : 'jQuery',
        $      : 'jQuery',
        jQuery : 'jQuery'
    },
    module    : {
        rules : [
            {
                test    : /\.vue$/,
                loader  : 'vue-loader',
                options : vueLoaderConfig
            },
            {
                test   : /\.json$/,
                loader : 'json-loader',
            },
            {
                test    : /\.js$/,
                loader  : 'babel-loader',
                exclude : /node_modules/
            },
            {
                test    : /\.(png|jpg|gif|svg)$/,
                loader  : 'file-loader',
                options : {
                    limit : 10000,
                    name  : '[name].[ext]?[hash]'
                }
            }
        ]
    },
    resolve   : {
        alias : {
            'vue$' : 'vue/dist/vue',
            //styles: path.resolve(__dirname, '../src/path/to/your/styles') // @import styles/variables
        }
    },

    resolveLoader : {
        alias : {
            //    'scss-loader' : 'sass-loader' // to use lang="scss" instead of lang="sass" :)
        }
    }
};

if (process.env.NODE_ENV === 'production') {

    module.exports.output.filename = 'js/upb-[name].min.js';

    module.exports.devtool = '#source-map';
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.ProvidePlugin({
            Vue          : 'vue',
            'window.Vue' : 'vue',
        }),
        //new webpack.optimize.CommonsChunkPlugin({name : 'vue', filename : 'js/vue.min.js'}),
        new webpack.DefinePlugin({
            'process.env' : {
                NODE_ENV : '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            sourceMap : false,
            compress  : {
                warnings : false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize : true
        }),
        new ExtractTextPlugin("css/upb-style.min.css"),
    ])
}
else {
    module.exports.plugins = [
        new webpack.ProvidePlugin({
            Vue          : 'vue',
            'window.Vue' : 'vue',
        }),
        //new webpack.optimize.CommonsChunkPlugin({name : 'vue', filename : 'js/vue.js'}),
        new webpack.LoaderOptionsPlugin({
            minimize : false,
            debug    : true,
        }),
        // new BundleAnalyzerPlugin(), // to see state
        // new ExtractTextPlugin("css/upb-style.css")
    ]
}
