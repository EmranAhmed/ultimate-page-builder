import toastr from "./toastr";
import extend from "extend";

class Helper {

    constructor(options) {

        toastr.options = extend(true, {
            positionClass : 'toast-top-right',
            timeOut       : 3000
        }, options);

        return toastr;
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

    Vue.Toast = new Helper(options);

    Object.defineProperty(Vue.prototype, '$toast', {
        value : Vue.Toast
    });
};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;
