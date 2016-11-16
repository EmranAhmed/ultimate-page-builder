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

module.exports = {
    plugins: [
        require('autoprefixer')({
            browsers : autoprefixerOptions
        })
    ]
}