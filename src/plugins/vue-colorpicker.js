import { util } from 'vue';

(function ($) {

    const vColorPicker = {};

    if (!$().wpColorPicker) {
        util.warn('wpColorPicker is not installed or found globally to use `vue-colorpicker` directive..', this);
    }

    vColorPicker.install = function (Vue, options) {

        Vue.directive('colorpicker', {

            bind : function (el, binding, vnode) {

            },

            update : function (newValue, oldValue, vnode) {

            },

            unbind : function (el) {
                //$(el).sortable("destroy");
            },

            componentUpdated : function () {},

            inserted : function (el, binding, vnode) {

                const options = {
                    change(event, ui){

                        console.log(ui.color.toString())

                        if (!vnode.context.onColorChange) {
                            util.warn('You need to implement the `onColorChange` method', vnode.context);
                        }

                        vnode.context.onColorChange(ui.color.toString());
                    }
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