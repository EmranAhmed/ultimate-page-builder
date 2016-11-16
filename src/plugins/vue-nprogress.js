import NProgress from './nprogress';

const VueNProgress   = {};
VueNProgress.install = function (Vue, options) {

    NProgress.configure(options || {
            parent      : '#progress-bar',
            showSpinner : false,
            minimum     : 0.6,
            trickleRate : 0.4
        });

    Vue.prototype.$progressbar = {
        show() {
            NProgress.start();
        },
        hide() {
            NProgress.done();
        }
    }
};

if (typeof exports == "object") {
    module.exports = VueNProgress
}
else if (typeof define == "function" && define.amd) {
    define([], function () {
        return VueNProgress
    })
}
else if (window.Vue) {
    window.VueNProgress = VueNProgress;
    Vue.use(VueNProgress)
}