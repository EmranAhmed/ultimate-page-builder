import { util } from 'vue';

(function ($) {

    const vSortable = {};

    if (!$().sortable) {
        throw new Error('jQuery UI Sortable not found');
    }

    vSortable.install = function (Vue, options) {

        Vue.directive('sortable', {

            bind : function (el, binding, vnode) {

            },

            update : function (newValue, oldValue, vnode) {

            },
            unbind : function (el) {
                $(el).sortable("destroy");
            },

            componentUpdated : function () {},

            inserted : function (el, binding, vnode) {

                const values = {oldIndex : 0, newIndex : 0};

                $(el).sortable(binding.value || {});

                $(el).sortable("option", "start", (event, ui) => {
                    values.oldIndex = ui.item.index();
                });

                $(el).sortable("option", "update", (event, ui) => {

                    values.newIndex = ui.item.index();

                    if (!vnode.context.onUpdate) {

                        util.warn('You need to implement the `onUpdate` method', vnode.context)
                        //throw new Error('require onUpdate method');
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
    else if (window.Vue) {
        window.vSortable = vSortable;
        Vue.use(vSortable)
    }

})(window.jQuery);