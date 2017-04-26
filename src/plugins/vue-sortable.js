import { util } from 'vue';

($ => {
    const vSortable = {};

    if (!$().sortable) {
        util.warn('jQueryUI Sortable not installed or found globally to use `vue-sortable` directive..', this);
    }

    vSortable.install = function (Vue, options) {

        Vue.directive('sortable', {

            bind (el, binding, vnode) {},

            update (el, binding, vnode) {},

            unbind (el) {
                $(el).sortable("destroy");
            },

            componentUpdated (el, binding, vnode) {},

            inserted (el, binding, vnode) {

                const values = {oldIndex : 0, newIndex : 0};

                $(el).sortable(binding.value || {});

                $(el).sortable("option", "start", (event, ui) => {
                    values.oldIndex = ui.item.index();

                    if (vnode.context.onStart) {
                        vnode.context.onStart(event);
                    }
                });

                $(el).sortable("option", "update", (event, ui) => {

                    values.newIndex = ui.item.index();

                    if (!vnode.context.onUpdate) {
                        util.warn('You need to implement the `onUpdate` method', vnode.context);
                    }

                    vnode.context.onUpdate(event, $.extend(true, {}, values));

                    // reset :)
                    values.oldIndex = 0;
                    values.newIndex = 0;
                });

                $(el).disableSelection();
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vSortable
    }
    else if (typeof define == "function" && define.amd) {

        define([], function () {
            return vSortable
        })
    }
    else if (typeof window !== 'undefined' && window.Vue) {

        window.vSortable = vSortable;
        Vue.use(vSortable)
    }
})(window.jQuery);