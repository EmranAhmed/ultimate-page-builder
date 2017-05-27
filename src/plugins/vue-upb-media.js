import { util } from "vue";
import "../js/upb-media";
import store from "../store";

($ => {
    const vImageMedia = {};

    if (_.isUndefined(wp) || _.isUndefined(wp.media)) {
        util.warn(`"wp.media" is not loaded or found globally to use "vue-image-media" directive..`, this);
    }

    vImageMedia.install = function (Vue, options) {

        Vue.directive('upb-media', {

            inserted (el, binding, vnode) {

                let frame;

                $('.new-button', el).on('click', function (event) {

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

                $('.remove-button', el).on('click', function (event) {
                    event.preventDefault();

                    if (!vnode.context.onRemove) {
                        util.warn(`You need to implement the "onRemove" method`, vnode.context);
                    }

                    vnode.context.onRemove(event);
                });
            }
        });
    };

    if (typeof exports == "object") {
        module.exports = vImageMedia
    }
    else if (typeof define == "function" && define.amd) {
        define([], function () {
            return vImageMedia
        })
    }
    else if (window.Vue) {
        window.vImageMedia = vImageMedia;
        Vue.use(vImageMedia)
    }
})(jQuery);