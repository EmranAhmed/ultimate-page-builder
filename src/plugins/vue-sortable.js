import { util } from "vue";

const Directive = {

    bind (el, binding, vnode) {},

    update (el, binding, vnode) {},

    unbind (el) {
        jQuery(el).sortable("destroy");
    },

    componentUpdated (el, binding, vnode) {},

    inserted (el, binding, vnode) {

        const values = {oldIndex : 0, newIndex : 0};

        jQuery(el).sortable(binding.value || {});

        jQuery(el).sortable("option", "start", (event, ui) => {
            values.oldIndex = ui.item.index();

            if (vnode.context.onStart) {
                vnode.context.onStart(event);
            }
        });

        jQuery(el).sortable("option", "update", (event, ui) => {

            values.newIndex = ui.item.index();

            if (!vnode.context.onUpdate) {
                util.warn('You need to implement the `onUpdate` method', vnode.context);
            }

            vnode.context.onUpdate(event, jQuery.extend(true, {}, values));

            // reset :)
            values.oldIndex = 0;
            values.newIndex = 0;
        });

        jQuery(el).disableSelection();
    }
};

const Plugin = (Vue, options = {}) => {

    if (!jQuery().sortable) {
        util.warn('jQueryUI Sortable not installed or found globally to use `vue-sortable` directive..', this);
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

    Vue.directive('sortable', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;