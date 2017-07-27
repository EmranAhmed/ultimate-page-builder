import { util } from "vue";

const Select2 = function (el, binding, vnode, init = true) {

    jQuery(el).select2(jQuery.extend(true, {}, binding.value));

    if (init) {

        jQuery(el).on("select2:select", (e) => {

            if (!vnode.context.onChange) {
                util.warn('You need to implement the `onChange` method', vnode.context);
            }

            vnode.context.onChange(e.params.data, e);

            //$(el).trigger('change.select2');

        });

        jQuery(el).on("select2:unselect", (e) => {

            if (!vnode.context.onRemove) {
                util.warn('You need to implement the `onRemove` method', vnode.context);
            }

            vnode.context.onRemove(e.params.data, e);

            //$(el).trigger('change.select2');

        });
    }
};

const Directive = {

    unbind(el) {
        jQuery(el).select2("destroy");
    },

    update(el, binding, vnode){

        if (!_.isUndefined(binding.value['ajax'])) {
            jQuery(el).select2("destroy");

            vnode.context.$nextTick(() => {
                Select2(el, binding, vnode, false);
            })
        }
    },

    inserted(el, binding, vnode) {
        Select2(el, binding, vnode);
    }

};

const Plugin = (Vue, options = {}) => {

    if (!jQuery().select2) {
        util.warn('select2 is not installed or found globally to use `vue-select2` directive..', this);
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

    Vue.directive('select2', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;