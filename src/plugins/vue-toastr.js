import toastr from './toastr';

import extend from 'extend';

(($, toast) => {

    const vToast = {};

    vToast.install = function (Vue, options) {

        // toastr.options

        toast.options = extend(true, {
            positionClass : 'toast-top-right',
            timeOut       : 3000
        }, options);

        Vue.prototype.$toast = toast
    }

    if (typeof exports == "object") {
        module.exports = vToast
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vToast
        })
    }
    else if (window.Vue) {
        window.vToast = vToast;
        Vue.use(vToast)
    }

})(window.jQuery, toastr);
