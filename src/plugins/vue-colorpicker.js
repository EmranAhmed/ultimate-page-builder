import { util } from 'vue';

($ => {
    const vColorPicker = {};

    if (!$().wpColorPicker) {
        util.warn('wpColorPicker is not installed or found globally to use `vue-colorpicker` directive..', this);
    }

    vColorPicker.install = function (Vue, options) {

        Vue.directive('colorpicker', {
            inserted (el, binding, vnode) {

                const options = {
                    change(event, ui){
                        if (!vnode.context.onColorChange) {
                            util.warn('You need to implement the `onColorChange` method', vnode.context);
                        }

                        vnode.context.onColorChange(ui.color);
                    },

                    // palettes : ['rgba(0,0,0,0.45)', '#000'] or false
                    // http://automattic.github.io/Iris/

                };

                $(el).wpColorPicker($.extend(true, options, binding.value || {}));

            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vColorPicker
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vColorPicker
        })
    }
    else if (window.Vue) {
        window.vColorPicker = vColorPicker;
        Vue.use(vColorPicker)
    }

})(window.jQuery);