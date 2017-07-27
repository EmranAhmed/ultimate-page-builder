import { util } from "vue";

const Directive = {

    bind (el, binding, vnode) {

    },

    update (el, binding, vnode) {
    },

    unbind (el) {
        jQuery(el).draggable("destroy");
    },

    componentUpdated (el, binding, vnode) {},

    inserted (el, binding, vnode) {

        jQuery(el).draggable({
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

};

const Plugin = (Vue, options = {}) => {

    if (!jQuery().draggable) {
        util.warn('jQueryUI Draggable not installed or found globally to use `vue-ui-draggable` directive..', this);
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

    Vue.directive('ui-draggable', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;
