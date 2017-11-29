import { util } from "vue";

const Directive = {

    inserted (el, binding, vnode) {

        const options = {
            change(event, ui){
                if (!vnode.context.onColorChange) {
                    util.warn('You need to implement the `onColorChange` method', vnode.context);
                }

                vnode.context.onColorChange(ui.color);
            },

            // palettes : ['rgba(0,0,0,0.45)', '#000'] or false
            // http://automattic.github.io/Iris/

        };

        jQuery(el).upbColorPicker(jQuery.extend(true, options, binding.value || {}));

    }
};

const Plugin = (Vue, options = {}) => {

    if (!jQuery().upbColorPicker) {
        util.warn('wpColorPicker is not installed or found globally to use `vue-colorpicker` directive..', this);
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

    Vue.directive('colorpicker', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;