import { util } from 'vue';
import store from '../store';

{

    const vDraggable = {};

    vDraggable.install = function (Vue, options) {

        Vue.directive('draggable', {

            bind (el, binding, vnode) {

            },

            update (el, binding, vnode) {

            },

            unbind (el, binding, vnode) {
                el.setAttribute("draggable", false);
            },

            componentUpdated () {},

            inserted (el, binding, vnode) {

                if (binding.value == 'soon') {
                    el.setAttribute("draggable", false);
                }
                else {
                    el.setAttribute("draggable", true);
                }

                el.classList.add('upb-draggable-element');

                el.addEventListener('dragstart', function (event) {
                    this.classList.add('upb-element-drag-start');
                    event.dataTransfer.setData("text", JSON.stringify(vnode.context.model));
                });

                el.addEventListener('dragend', function (event) {
                    this.classList.remove('upb-element-drag-start');
                });
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vDraggable
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vDraggable
        })
    }
    else if (window.Vue) {
        window.vDraggable = vDraggable;
        Vue.use(vDraggable)
    }
}