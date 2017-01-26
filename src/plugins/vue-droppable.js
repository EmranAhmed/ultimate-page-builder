import { util } from 'vue';
import store from '../store';

{
    const vDroppable = {};

    vDroppable.install = function (Vue, options) {

        Vue.directive('droppable', {

            bind(el, binding, vnode) {},

            update(newValue, oldValue, vnode) {},

            unbind (el) {},

            componentUpdated () {},

            inserted (el, binding, vnode) {

                el.addEventListener('dragover', function (event) {
                    event.preventDefault();
                });

                el.addEventListener('drop', function (event) {

                    if (!vnode.context.dropAccept) {
                        util.warn('You need to implement the `dropAccept` method', vnode.context);
                    }

                    if (!vnode.context.afterDrop) {
                        util.warn('You need to implement the `onDrop` method', vnode.context);
                    }

                    try {

                        let content = JSON.parse(event.dataTransfer.getData("text"));

                        // Drop Accept should return true or false
                        if (vnode.context.dropAccept(content)) {
                            vnode.context.afterDrop(content, true);
                        }
                        else {
                            vnode.context.afterDrop(content, false);
                        }
                    } catch (e) {
                        console.info('Some thing was wrong on drop', e)
                    }
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
}