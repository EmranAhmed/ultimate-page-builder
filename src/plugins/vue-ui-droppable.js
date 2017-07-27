import { util } from "vue";
import extend from "extend";

const Directive = {

    bind (el, binding, vnode) {
    },

    update (el, binding, vnode) {
    },

    unbind(el) {
        jQuery('.upb-add-element-message-regular', el).droppable("destroy");
    },

    componentUpdated (el, binding, vnode) {
    },

    inserted (el, binding, vnode) {

        jQuery('.upb-add-element-message-regular', el).droppable({
            hoverClass  : "ui-droppable-hover",
            activeClass : "ui-droppable-active",
            tolerance   : "pointer",
            addClasses  : false,
            disabled    : false,

            drop : function (event, ui) {

                let draggable = ui.draggable.context.__vue__;
                let droppable = vnode.context;

                //console.log(draggable);

                // console.log('from ', draggable.$parent.model._upb_options._keyIndex, 'to ', droppable.model._upb_options._keyIndex)

                if (!draggable || draggable.$parent.model._upb_options._keyIndex == droppable.model._upb_options._keyIndex) {
                    //console.log(`You cannot do this :)`);
                }
                else {
                    let getIndex = draggable.model._upb_options._keyIndex.split('/').pop();
                    let contents = extend(true, {}, draggable.$parent.model.contents.splice(getIndex, 1).pop());

                    //delete contents._upb_options._keyIndex;
                    contents._upb_options.focus = false;

                    vnode.context.afterDrop(contents, true);
                }
            }
        });

    }

};

const Plugin = (Vue, options = {}) => {

    if (!jQuery().droppable) {
        util.warn('jQueryUI Droppable not installed or found globally to use `vue-ui-droppable` directive..', this);
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

    Vue.directive('ui-droppable', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;