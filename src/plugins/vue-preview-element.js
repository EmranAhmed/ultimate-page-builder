import { util } from "vue";

const Directive = {
    bind  (el, binding, vnode) {},

    update (newValue, oldValue, vnode) {},

    unbind  (el) {},

    componentUpdated  () {},

    inserted  (el, binding, vnode) {

        // jQuery(el).addClass(`upb-preview-element`).addClass(`${vnode.context.model.tag}-preview`);

        // No Contents Class
        if (!_.isUndefined(vnode.context.model['contents']) && _.isEmpty(vnode.context.model.contents) && (_.isString(vnode.context.model.contents) || _.isArray(vnode.context.model.contents))) {
            //    $(el).addClass(`upb-preview-element-no-contents`)
        }

        jQuery(el).find('>.upb-preview-mini-toolbar').on('mouseenter', function (event) {
            event.stopPropagation();
            vnode.context.model._upb_options.focus = true;
        });

        jQuery(el).find('>.upb-preview-mini-toolbar').on('mouseleave', function (event) {
            event.stopPropagation();
            vnode.context.model._upb_options.focus = false;
        });
    }
};

const Plugin = (Vue, options = {}) => {

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

    Vue.directive('preview-element', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;
