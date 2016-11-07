'use strict';

const gulp          = require('gulp');
const plumber       = require('gulp-plumber');
const sass          = require('gulp-sass');
const sourcemaps    = require('gulp-sourcemaps');
const autoprefixer  = require('gulp-autoprefixer');
//const lineec       = require('gulp-line-ending-corrector');
const rename        = require('gulp-rename');
const browserSync   = require('browser-sync').create();
//const imagemin     = require('gulp-imagemin');
const wpPot         = require('gulp-wp-pot');
//const mmq          = require('gulp-merge-media-queries');
const minifycss     = require('gulp-uglifycss'); // Minifies CSS files.
const sort          = require('gulp-sort'); // Recommended to prevent unnecessary changes in pot-file.
const concat        = require('gulp-concat');
const uglify        = require('gulp-uglify');
const babel         = require('gulp-babel');
const webpack       = require("webpack");
const webpackConfig = require("./webpack.config.js");

const autoprefixerOptions = [
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
];

const dirs = {
    src  : './src',
    dest : './assets',
    node : './node_modules'
};

const browserSyncOptions = {
    proxy  : "wp-starter.dev",
    notify : false
};

const wpPotOptions = {
    'domain'         : 'ultimate-page-builder',
    'destFile'       : 'ultimate-page-builder.pot',
    'package'        : 'ultimate-page-builder',
    'bugReport'      : 'https://themehippo.com/contact/',
    'lastTranslator' : 'ThemeHippo <themehippo@gmail.com>',
    'team'           : 'ThemeHippo <themehippo@gmail.com>',
    'translatePath'  : './languages'
};

// Scripts

gulp.task('scripts:dev', () => {
    return gulp.src(`${dirs.src}/js/*.js`)
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(babel({
            presets : ["es2015"]
        }).on('error', console.error.bind(console)))
        .pipe(plumber.stop())
        .pipe(sourcemaps.write({includeContent : false}))
        .pipe(gulp.dest(`${dirs.dest}/js`));
});

gulp.task('scripts:build', () => {
    return gulp.src(`${dirs.src}/js/*.js`)
        .pipe(plumber())
        .pipe(babel({
            presets : ["es2015"]
        }).on('error', console.error.bind(console)))
        //.pipe(gulp.dest(`${dirs.builder_dist}`))
        .pipe(uglify())
        .pipe(plumber.stop())
        .pipe(rename({
            suffix : ".min"
        }))
        .pipe(gulp.dest(`${dirs.dest}/js`));
});

// Styles

gulp.task('styles:dev', () => {
    return gulp.src(`${dirs.dest}/scss/*.scss`)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({
            errLogToConsole : true,
            // outputStyle     : 'compact',
            //outputStyle     : 'compressed',
            // outputStyle: 'nested',
            outputStyle     : 'expanded',
            precision       : 10
        })).on('error', console.error.bind(console))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(sourcemaps.write({includeContent : false}))
        .pipe(plumber.stop())
        .pipe(gulp.dest(`${dirs.dest}/css`))
});

gulp.task('styles:build', () => {
    return gulp.src(`${dirs.dest}/scss/*.scss`)
        //.pipe(sourcemaps.init())
        .pipe(sass({
            errLogToConsole : true,
            //outputStyle     : 'compact',
            outputStyle     : 'compressed',
            // outputStyle: 'nested',
            // outputStyle: 'expanded',
            precision       : 10
        })).on('error', console.error.bind(console))
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(minifycss({
            "maxLineLen"   : 80,
            "uglyComments" : true
        }))
        //.pipe(sourcemaps.write({includeContent : false}))
        .pipe(rename({
            suffix : ".min"
        }))
        .pipe(gulp.dest(`${dirs.dest}/css`))
});

// Webpack

gulp.task('webpack:build', (callback) => {

    let buildConfig             = Object.create(webpackConfig);
    buildConfig.devtool         = '#source-map';
    buildConfig.output.filename = 'upb-build.min.js';
    buildConfig.plugins         = (buildConfig.plugins || []).concat(
        new webpack.DefinePlugin({
            "process.env" : {
                "NODE_ENV" : JSON.stringify("production")
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress : {
                warnings : false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize : true
        })
    );

    webpack(buildConfig, function (err, stats) {
        callback();
    })
});

/*let devConfig             = Object.create(webpackConfig);
 devConfig.devtool         = '#eval-source-map';
 devConfig.debug           = true;
 devConfig.watch           = true;
 devConfig.output.filename = 'upb-build.js';
 let devPack               = webpack(devConfig)*/

gulp.task('webpack:dev', (callback) => {


    // run webpack
    /*devPack.run(function (err, stats) {
     callback();
     });*/

    let devConfig     = Object.create(webpackConfig);
    devConfig.devtool = '#eval-source-map';
    // devConfig.debug           = true;
    // devConfig.watch           = true;
    devConfig.output.filename = 'upb-build.js';

    devConfig.plugins = (devConfig.plugins || []).concat(
        new webpack.LoaderOptionsPlugin({
            minimize : false,
            debug    : true
        })
    );

    webpack(devConfig, function (err, stats) {
        callback();
    })
});

// browser-sync

gulp.task('browser-sync', () => {
    browserSync.init({

        // For more options
        // @link http://www.browsersync.io/docs/options/

        // Project URL.
        proxy : browserSyncOptions.proxy,

        // `true` Automatically open the browser with BrowserSync live server.
        // `false` Stop the browser from automatically opening.
        open : true,

        // Inject CSS changes.
        // Commnet it to reload browser for every CSS change.
        injectChanges : true,

        // Use a specific port (instead of the one auto-detected by Browsersync).
        // port: 7000,

    });
});

// translate

gulp.task('translate', () => {
    return gulp.src(`./**/*.php`)
        .pipe(sort())
        .pipe(wpPot(wpPotOptions))
        .pipe(gulp.dest(wpPotOptions.translatePath))
});

// npm run build
gulp.task('build', ['translate', 'webpack:build', 'styles:build', 'scripts:build']);

// npm run dev
gulp.task('dev', ['webpack:dev', 'styles:dev', 'scripts:dev'], () => {
    gulp.watch('./**/*.php'); // Reload on PHP file changes.
    gulp.watch(`${dirs.dest}/scss/*.scss`, ['styles:dev']); // Reload on SCSS file changes.
    gulp.watch(`${dirs.src}/js/*.js`, ['scripts:dev']); // Reload on customJS file changes.
    gulp.watch(`${dirs.src}/**/*`, ['webpack:dev']); // Reload on customJS file changes.
});