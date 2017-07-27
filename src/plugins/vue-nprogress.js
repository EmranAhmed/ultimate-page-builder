import NProgress from "./nprogress";
import extend from "extend";

class Helper {

    constructor(options) {
        NProgress.configure(extend(true, {
            parent      : '#progress-bar',
            showSpinner : false,
            minimum     : 0.6,
            trickleRate : 0.4
        }, options));
    }

    show() {
        NProgress.start();
    }

    hide() {
        NProgress.done();
    }
}

// Usages:
//
// The helper globally `Vue.Helper` or in a Vue instance `this.$helper`
// import Helper from "./Helper";
// Vue.use(Helper, { someOption: true })

const Plugin = (Vue, options = {}) => {

    // Install once example:
    // If you plugin need to load only once :)
    if (Plugin.installed) {
        return;
    }

    // Install Multi example:
    // If you plugin need to load multiple time :)
    /*if (Plugin.installed) {
     Plugin.installed = false;
     }*/

    Vue.ProgressBar = new Helper(options);

    Object.defineProperty(Vue.prototype, '$progressbar', {
        value : Vue.ProgressBar
    });

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;