import { util } from 'vue';

($ => {
    const vSelect2 = {};

    if (!$().select2) {
        util.warn('select2 is not installed or found globally to use `vue-select2` directive..', this);
    }

    vSelect2.init = function (el, binding, vnode, init = true) {
        $(el).select2($.extend(true, {}, binding.value));

        if (init) {

            $(el).on("select2:select", (e) => {

                if (!vnode.context.onChange) {
                    util.warn('You need to implement the `onChange` method', vnode.context);
                }

                vnode.context.onChange(e.params.data, e);

                //$(el).trigger('change.select2');

            });

            $(el).on("select2:unselect", (e) => {

                if (!vnode.context.onRemove) {
                    util.warn('You need to implement the `onRemove` method', vnode.context);
                }

                vnode.context.onRemove(e.params.data, e);

                //$(el).trigger('change.select2');

            });
        }
    };

    vSelect2.install = function (Vue, options) {

        Vue.directive('select2', {

            unbind(el) {
                $(el).select2("destroy");
            },

            update(el, binding, vnode){

                if (!_.isUndefined(binding.value['ajax'])) {
                    $(el).select2("destroy");

                    vnode.context.$nextTick(()=> {
                        vSelect2.init(el, binding, vnode, false);
                    })

                }
            },

            inserted(el, binding, vnode) {
                vSelect2.init(el, binding, vnode);
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vSelect2
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vSelect2
        })
    }
    else if (window.Vue) {
        window.vSelect2 = vSelect2;
        Vue.use(vSelect2)
    }

})(jQuery);