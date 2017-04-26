const mix      = require('laravel-mix');
const wpPot    = require('wp-pot');
const fsExtra  = require("fs-extra");
const path     = require("path");
const cliColor = require("cli-color");
const emojic   = require("emojic");
const browsers = [
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
const min      = mix.config.inProduction ? '.min' : '';

if (process.env.NODE_ENV == 'bundle') {
    mix.then(function () {
        let bundledir = path.basename(path.resolve(__dirname));
        let copyfrom  = path.resolve(__dirname);
        let copyto    = path.resolve(bundledir);
        let includes  = ['assets',
                         'elements',
                         'fonts',
                         'images',
                         'includes',
                         'languages',
                         'templates',
                         'LICENSE.txt',
                         'README.txt',
                         `${bundledir}.php`];
        fsExtra.ensureDir(copyto, function (err) {
            if (err) return console.error(err)

            includes.map(include=> {

                fsExtra.copy(`${copyfrom}/${include}`, `${copyto}/${include}`, function (err) {
                    if (err) return console.error(err)

                    console.log(cliColor.white(`=> ${emojic.smiley}  ${include} copied...`));

                    /*if (include == 'assets') {
                     // Just Removed SCSS Dir
                     fsExtra.removeSync(`${copyto}/${include}/scss`);
                     }*/
                })
            });

            console.log(cliColor.white(`=> ${emojic.whiteCheckMark}  Build directory created`));
        })
    });
}
else {

    mix.generatePot = function () {

        wpPot({
            package        : 'ultimate-page-builder',
            bugReport      : 'https://github.com/EmranAhmed/ultimate-page-builder/issues',
            lastTranslator : 'Emran Ahmed <emran.bd.08@gmail.com>',
            team           : 'ThemeHippo <themehippo@gmail.com>',
            src            : '*.php',
            domain         : 'ultimate-page-builder',
            destFile       : `languages/ultimate-page-builder.pot`
        });

        return this;
    };

    mix.options({
        // extractVueStyles : mix.config.inProduction,
        extractVueStyles : `assets/css/upb-style${min}.css`,
        postCss          : [require('autoprefixer')({browsers})],
        uglify           : {
            sourceMap : false,
            compress  : {
                warnings : false
            }
        },
        babel            : {
            "presets"      : [
                ["es2015", {"modules" : false}]
            ],
            cacheDirectory : true
        }
    });

    mix.sourceMaps();

    mix.js('src/builder.js', `assets/js/upb-builder${min}.js`);

    ['select2', 'upb-boilerplate', 'upb-scoped-polyfill', 'wp-color-picker-alpha'].map((name)=> mix.babel(`src/js/${name}.js`, `assets/js/${name}${min}.js`));

    // Vendor, Check CommonsChunkPlugin on webpack.config.js
    mix.extract(['vue', 'vue-router', 'extend', 'sprintf-js', 'sanitize-html', 'copy-to-clipboard'], `assets/js/upb-vendor${min}.js`);

    ['select2', 'upb-boilerplate', 'upb-grid', 'upb-preview', 'upb-skeleton'].map((name)=> mix.sass(`src/scss/${name}.scss`, `assets/css/${name}${min}.css`));

}

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.standaloneSass('src', output); <-- Faster, but isolated from Webpack.
// mix.less(src, output);
// mix.stylus(src, output);
// mix.browserSync('my-site.dev');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });