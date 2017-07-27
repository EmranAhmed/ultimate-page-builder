import { util } from "vue";

const Directive = {

    bind (el, binding, vnode) {

    },

    update (el, binding, vnode) {
    },

    unbind (el) {
        jQuery(el).draggable("destroy");
    },

    componentUpdated(el, binding, vnode) {

        let [left, top] = binding.value.split(' ');

        jQuery(el).css('left', left.trim());
        jQuery(el).css('top', top.trim());
    },

    inserted (el, binding, vnode) {

        let [left, top] = binding.value.split(' ');

        jQuery(el).css('left', left.trim());
        jQuery(el).css('top', top.trim());

        jQuery(el).draggable({
            cursor      : "crosshair",
            cursorAt    : {top : 8, left : 8},
            containment : "parent",

            drag : function (event, ui) {

                if (!vnode.context.pointerMovedTo) {
                    util.warn('You need to implement the `pointerMovedTo` method', vnode.context);
                }

                let imgW = jQuery(this).next()[0].naturalWidth;
                let imgH = jQuery(this).next()[0].naturalHeight;
                let bg   = jQuery(this).next()[0].currentSrc;

                let appWidth  = jQuery(this).parent().width();
                let appHeight = jQuery(this).parent().height();

                let left = Math.round((ui.position.left / (appWidth / 100)));
                let top  = Math.round((ui.position.top / (appHeight / 100)));

                vnode.context.pointerMovedTo(`${left}% ${top}%`);
            }
        });
    }
};

const Plugin = (Vue, options = {}) => {

    if (!jQuery().draggable) {
        util.warn('jQueryUI Draggable not installed or found globally to use `vue-background-position` directive..', this);
    }

    // Install once example:
    // If you plugin need to load only once :)
    if (Plugin.installed) {
        return;
    }

    // Install Multi example:
    // If you plugin need to load multiple time :)
    /*if (Plugin.installed) {
     Plugin.installed = false;
     }*/

    Vue.directive('background-position', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;
