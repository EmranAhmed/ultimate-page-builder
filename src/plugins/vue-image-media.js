import { util } from 'vue';

($ => {
    const vImageMedia = {};

    if (_.isUndefined(wp) || _.isUndefined(wp.media)) {
        util.warn('wp.media is not loaded or found globally to use `vue-image-select` directive..', this);
    }

    vImageMedia.install = function (Vue, options) {

        Vue.directive('image-media', {

            unbind (el) {

            },

            inserted (el, binding, vnode) {

                let frame;

                $(el).find('.new-button').on('click', function (event) {

                    event.preventDefault();

                    // if the frame already exists, open it
                    if (frame) {
                        frame.open();
                        return;
                    }

                    // set our settings
                    frame = wp.media({
                        title    : vnode.context.attributes.title,
                        multiple : false,
                        library  : {
                            type : 'image'
                        },
                        button   : {
                            text : vnode.context.attributes.buttons.add
                        }
                    });

                    // set up our select handler
                    frame.on('select', function () {
                        let selection = frame.state().get('selection');

                        if (!selection) return;

                        // loop through the selected files
                        selection.each(function (attachment) {

                            if (_.isUndefined(attachment.attributes.sizes[vnode.context.attributes.size])) {
                                console.warn(`Media Image size "${vnode.context.attributes.size}" is not available, try re-generate thumbnails. Using full sized for fallback. Available sizes are:`)
                                console.table(attachment.attributes.sizes);
                                vnode.context.attributes.size = 'full';
                            }

                            let src = attachment.attributes.sizes[vnode.context.attributes.size].url;
                            let id  = attachment.id;

                            if (!vnode.context.onSelect) {
                                util.warn('You need to implement the `onSelect` method', vnode.context);
                            }

                            vnode.context.onSelect(event, id, src);

                        });
                    });

                    // open the frame
                    frame.open();

                });

                $(el).find('.remove-button').on('click', function (event) {

                    event.preventDefault();

                    if (!vnode.context.onRemove) {
                        util.warn('You need to implement the `onRemove` method', vnode.context);
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