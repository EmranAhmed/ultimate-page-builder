import { util } from 'vue';

($ => {

    const vPreviewElement = {};

    vPreviewElement.install = function (Vue, options) {

        Vue.directive('preview-element', {

            bind  (el, binding, vnode) {},

            update (newValue, oldValue, vnode) {},

            unbind  (el) {},

            componentUpdated  () {},

            inserted  (el, binding, vnode) {

                // $(el).addClass(`upb-preview-element`).addClass(`${vnode.context.model.tag}-preview`);

                // No Contents Class
                if (!_.isUndefined(vnode.context.model['contents']) && _.isEmpty(vnode.context.model.contents) && (_.isString(vnode.context.model.contents) || _.isArray(vnode.context.model.contents))) {
                    //    $(el).addClass(`upb-preview-element-no-contents`)
                }

                $(el).find('>.upb-preview-mini-toolbar').on('mouseenter', function (event) {
                    event.stopPropagation();
                    vnode.context.model._upb_options.focus = true;
                });

                $(el).find('>.upb-preview-mini-toolbar').on('mouseleave', function (event) {
                    event.stopPropagation();
                    vnode.context.model._upb_options.focus = false;
                });
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vPreviewElement
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vPreviewElement
        })
    }
    else if (window.Vue) {
        window.vPreviewElement = vPreviewElement;
        Vue.use(vPreviewElement)
    }

})(window.jQuery);
