const mix      = require('wp-mix');
const fsExtra  = require("fs-extra");
const path     = require("path");
const cliColor = require("cli-color");
const emojic   = require("emojic");
const min      = Mix.inProduction() ? '.min' : '';

if (process.env.NODE_ENV == 'package') {
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

            includes.map(include => {

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

    mix.banner({
        banner : "Ultimate Page Builder v1.0.0 \n\nAuthor: Emran Ahmed ( https://themehippo.com/ ) \nDate: " + new Date().toLocaleString() + "\nReleased under the MIT license."
    });

    mix.notification({
        title        : 'Ultimate Page Builder',
        contentImage : Mix.paths.root('images/logo.png')
    });

    if (Mix.inProduction()) {
        mix.generatePot({
            package   : 'ultimate-page-builder',
            bugReport : 'https://github.com/EmranAhmed/ultimate-page-builder/issues',
            src       : '*.php',
            domain    : 'ultimate-page-builder',
            destFile  : `languages/ultimate-page-builder.pot`
        });
    }

    mix.options({
        extractVueStyles : `assets/css/upb-style${min}.css`,
    });

    mix.setCommonChunkFileName('upb-common');

    mix.autoload({
        vue : ['window.Vue', 'Vue']
    });

    mix.sourceMaps();

    mix.js('src/builder.js', `assets/js/upb-builder${min}.js`);

    // mix.js('src/js/upb-media.js', `assets/js/upb-media${min}.js`);

    ['upb-preview-element-inline-scripts', 'select2', 'upb-boilerplate', 'wp-color-picker-alpha'].map((name) => mix.babel(`src/js/${name}.js`, `assets/js/${name}${min}.js`));

    // Vendor, Check CommonsChunkPlugin on webpack.config.js
    mix.extract(['vue', 'vue-router', 'extend', 'sprintf-js', 'sanitize-html', 'copy-to-clipboard'], `assets/js/upb-vendor${min}.js`);

    ['select2', 'upb-boilerplate', 'upb-grid', 'upb-preview', 'upb-skeleton'].map((name) => mix.sass(`src/scss/${name}.scss`, `assets/css/${name}${min}.css`));

}

// Full API
// mix.generatePot({})
// mix.banner({})
// mix.notification({})
// mix.postCssBrowsers({})
// mix.setCommonChunkFileName('upb-common');
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