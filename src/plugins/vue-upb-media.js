import { util } from "vue";
import "../js/upb-media";
import store from "../store";

const Directive = {

    inserted(el, binding, vnode) {

        let frame;

        jQuery('.new-button', el).on('click', function (event) {

            event.preventDefault();

            // if the frame already exists, open it
            if (frame) {
                frame.open();
                return;
            }

            frame = new wp.media.view.MediaFrame.UPBMedia({
                title                   : vnode.context.attributes.title,
                button                  : {
                    text : vnode.context.attributes.buttons.add
                },
                upbOptions              : {
                    size : vnode.context.attributes.size
                },
                selectedDisplaySettings : {
                    size : vnode.context.attributes.size
                },
                library                 : {
                    type : vnode.context.attributes.library
                },
                url                     : store.isLocal(vnode.context.attributes.value) ? '' : vnode.context.attributes.value
            });

            frame.on('insert', function () {
                let state = frame.state(), attachment = {};

                if ('upb-embed' === state.get('id')) {
                    _.extend(attachment, {id : 0}, state.props.toJSON());
                }
                else {
                    _.extend(attachment, state.get('selection').first().toJSON(), {url : state.get('selection').first().toJSON().src});
                }

                if (!vnode.context.onInsert) {
                    util.warn(`You need to implement the "onInsert" method`, vnode.context);
                    return false;
                }

                vnode.context.onInsert(event, attachment);

            });

            frame.on('open', function () {
                let id        = vnode.context.id;
                let size      = vnode.context.size;
                let selection = frame.state().get('selection');
                selection.reset(id ? [wp.media.attachment(id)] : []);
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

        jQuery(el).on('click', '.preview', function (event) {
            event.preventDefault();
            let metadata = {
                id            : vnode.context.id || 0,
                url           : vnode.context.src,
                size          : vnode.context.size,
                attachment_id : vnode.context.id || 0,
                error         : false
            };

            frame = wp.media({
                frame    : 'image',
                state    : 'image-details',
                metadata : metadata
            });

            frame.state('image-details').on('update', function () {
                let attachment = frame.state().attributes.image.toJSON();
                vnode.context.onInsert(event, attachment);
                _.delay(() => { frame = null })
            });

            frame.on('close', function () {
                _.delay(() => { frame = null })
            });

            frame.open()
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