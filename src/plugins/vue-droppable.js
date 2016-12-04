import { util } from 'vue';
import store from '../store';

(function () {

    const vDroppable = {};

    vDroppable.install = function (Vue, options) {

        Vue.directive('droppable', {

            bind : function (el, binding, vnode) {

            },

            update : function (newValue, oldValue, vnode) {

            },

            unbind : function (el) {},

            componentUpdated : function () {},

            inserted : function (el, binding, vnode) {

                el.addEventListener('dragover', function (event) {
                    event.preventDefault();
                });

                el.addEventListener('drop', function (event) {
                    vnode.context.model.contents.push(JSON.parse(event.dataTransfer.getData("text")));

                    store.stateChanged();
                });
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vDroppable
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vDroppable
        })
    }
    else if (window.Vue) {
        window.vDropable = vDroppable;
        Vue.use(vDroppable)
    }
})();