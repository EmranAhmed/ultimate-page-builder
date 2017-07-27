import { util } from "vue";
import "../js/upb-media";
import store from "../store";

const Directive = {

    inserted (el, binding, vnode) {

        let frame;

        jQuery('.new-button', el).on('click', function (event) {

            event.preventDefault();

            // if the frame already exists, open it
            if (frame) {
                frame.open();
                return;
            }

            frame = new wp.media.view.MediaFrame.UPBMedia({

                title      : vnode.context.attributes.title,
                button     : {
                    text : vnode.context.attributes.buttons.add
                },
                upbOptions : {
                    size : vnode.context.attributes.size
                },
                library    : {
                    type : vnode.context.attributes.library
                },
                url        : store.isLocal(vnode.context.attributes.value) ? '' : vnode.context.attributes.value,
            });

            frame.on('insert', function () {
                let state = frame.state(),
                    url, id;

                if (state && 'upb-embed' === state.get('id')) {
                    url = state.props.get('url');
                    id  = null;
                }
                else {
                    url = frame.state().get('selection').first().toJSON().src;
                    id  = frame.state().get('selection').first().toJSON().id;
                }

                if (!vnode.context.onInsert) {
                    util.warn(`You need to implement the "onInsert" method`, vnode.context);
                    return false;
                }

                vnode.context.onInsert(event, id, url);

            });

            frame.open();
        });

        jQuery('.remove-button', el).on('click', function (event) {
            event.preventDefault();

            if (!vnode.context.onRemove) {
                util.warn(`You need to implement the "onRemove" method`, vnode.context);
            }

            vnode.context.onRemove(event);
        });
    }

};

const Plugin = (Vue, options = {}) => {

    if (_.isUndefined(wp) || _.isUndefined(wp.media)) {
        util.warn(`"wp.media" is not loaded or found globally to use "vue-image-media" directive..`, this);
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

    Vue.directive('upb-media', Directive)

};

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(Plugin);
}

export default Plugin;