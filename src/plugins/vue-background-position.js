import { util } from 'vue';

($ => {
    const vBackgroundPosition = {};

    if (!$().draggable) {
        util.warn('jQueryUI Draggable not installed or found globally to use `vue-background-position` directive..', this);
    }

    vBackgroundPosition.install = function (Vue, options) {

        Vue.directive('background-position', {

            bind : function (el, binding, vnode) {

            },

            update : function (el, binding, vnode) {
            },

            unbind : function (el) {
                $(el).draggable("destroy");
            },

            componentUpdated : function (el, binding, vnode) {

                let [left, top] = binding.value.split(' ');

                $(el).css('left', left.trim());
                $(el).css('top', top.trim());

            },

            inserted : function (el, binding, vnode) {

                let [left, top] = binding.value.split(' ');

                $(el).css('left', left.trim());
                $(el).css('top', top.trim());

                $(el).draggable({
                    cursor      : "crosshair",
                    cursorAt    : {top : 8, left : 8},
                    containment : "parent",

                    drag : function (event, ui) {

                        if (!vnode.context.pointerMovedTo) {
                            util.warn('You need to implement the `pointerMovedTo` method', vnode.context);
                        }

                        let imgW = $(this).next()[0].naturalWidth;
                        let imgH = $(this).next()[0].naturalHeight;
                        let bg   = $(this).next()[0].currentSrc;

                        let appWidth  = $(this).parent().width();
                        let appHeight = $(this).parent().height();

                        let left = Math.round((ui.position.left / (appWidth / 100)));
                        let top  = Math.round((ui.position.top / (appHeight / 100)));

                        vnode.context.pointerMovedTo(`${left}% ${top}%`);
                    }
                });

            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vBackgroundPosition
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vBackgroundPosition
        })
    }
    else if (window.Vue) {
        window.vBackgroundPosition = vBackgroundPosition;
        Vue.use(vBackgroundPosition)
    }

})(window.jQuery);