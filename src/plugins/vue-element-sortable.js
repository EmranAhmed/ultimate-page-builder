import { util } from 'vue';

($ => {
    const vElementSortable = {};

    if (!$().sortable) {
        util.warn('jQueryUI Sortable not installed or found globally to use `vue-element-sortable` directive..', this);
    }

    vElementSortable.install = function (Vue, options) {

        Vue.directive('element-sortable', {

            bind (el, binding, vnode) {

            },

            update (newValue, oldValue, vnode) {

            },

            unbind (el) {
                $(el).sortable("destroy");
            },

            componentUpdated : function () {},

            inserted (el, binding, vnode) {

                const values = {
                    oldIndex : 0,
                    newIndex : 0
                };

                //console.log('hello sortable');

                $(el).sortable({
                    //connectWith : ".upb-column-preview",
                    //handle: ".upb-preview-mini-toolbar",
                });

                $(el).sortable("option", "start", (event, ui) => {

                    console.log(vnode.context.model);

                    //values.oldIndex = ui.item.index();

                    /*if (vnode.context.onStart) {
                     vnode.context.onStart(event);
                     }*/
                });

                $(el).sortable("option", "update", (event, ui) => {

                    //values.newIndex = ui.item.index();

                    console.log(vnode.context.$parent);

                    /*if (!vnode.context.onUpdate) {
                     util.warn('You need to implement the `onUpdate` method', vnode.context);
                     }*/

                    //vnode.context.onUpdate(event, $.extend(true, {}, values));

                    // reset :)
                    values.oldIndex = 0;
                    values.newIndex = 0;
                });

                $(el).disableSelection();
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vElementSortable
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vElementSortable
        })
    }
    else if (window.Vue) {
        window.vElementSortable = vElementSortable;
        Vue.use(vElementSortable)
    }

})(window.jQuery);