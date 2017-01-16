import { util } from 'vue';
import store from '../store'

($ => {
    const vUIDraggable = {};

    if (!$().draggable) {
        util.warn('jQueryUI Draggable not installed or found globally to use `vue-ui-draggable` directive..', this);
    }

    vUIDraggable.install = function (Vue, options) {

        Vue.directive('ui-draggable', {

            bind : function (el, binding, vnode) {

            },

            update : function (el, binding, vnode) {
            },

            unbind : function (el) {
                $(el).draggable("destroy");
            },

            componentUpdated : function (el, binding, vnode) {},

            inserted : function (el, binding, vnode) {

                $(el).draggable({
                    //iframeFix  : true,
                    //helper     : 'clone',
                    opacity    : 0.35,
                    revert     : "invalid",
                    handle     : ".upb-preview-mini-toolbar li.upb-move-element",
                    addClasses : false,
                    stop       : (event, ui) => {
                        ui.helper.attr('style', '');
                    }
                });
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vUIDraggable
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vUIDraggable
        })
    }
    else if (window.Vue) {
        window.vUIDraggable = vUIDraggable;
        Vue.use(vUIDraggable)
    }
})(window.jQuery);