import { util } from "vue";

const Directive = {

    bind (el, binding, vnode) {

    },

    update (el, binding, vnode) {

    },

    unbind (el, binding, vnode) {
        el.setAttribute("draggable", false);
    },

    componentUpdated () {},

    inserted (el, binding, vnode) {

        if (binding.value == 'soon') {
            el.setAttribute("draggable", false);
        }
        else {
            el.setAttribute("draggable", true);
        }

        el.classList.add('upb-draggable-element');

        el.addEventListener('dragstart', function (event) {
            this.classList.add('upb-element-drag-start');
            event.dataTransfer.setData("text", JSON.stringify(vnode.context.model));
        });

        el.addEventListener('dragend', function (event) {
            this.classList.remove('upb-element-drag-start');
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

    Vue.directive('draggable', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;
