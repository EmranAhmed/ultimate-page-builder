import { util } from 'vue';

($ => {
    const vImageMedia = {};

    if (_.isUndefined(wp) || _.isUndefined(wp.media)) {
        util.warn(`"wp.media" is not loaded or found globally to use "vue-image-media" directive..`, this);
    }

    vImageMedia.install = function (Vue, options) {

        Vue.directive('image-media', {

            inserted (el, binding, vnode) {

                let frame;

                $(el).find('.new-button').on('click', function (event) {

                    event.preventDefault();

                    // if the frame already exists, open it
                    if (frame) {
                        frame.open();
                        return;
                    }

                    /*let insertImage = wp.media.controller.Library.extend({
                     defaults : _.defaults({
                     //id:        'insert-image',
                     //title:      vnode.context.attributes.title,
                     //allowLocalEdits     : true,
                     displaySettings : true,
                     date            : false,
                     //displayUserSettings : true,
                     //multiple            : false,
                     type            : 'image' //audio, video, application/pdf, ... etc
                     }, wp.media.controller.Library.prototype.defaults)
                     });

                     // set our settings
                     var frame2 = wp.media({
                     title    : vnode.context.attributes.title,
                     multiple : false,
                     library  : {
                     type : 'image'
                     },
                     button   : {
                     text : vnode.context.attributes.buttons.add
                     },
                     states   : [
                     new insertImage()
                     ]
                     });*/

                    frame = wp.media({
                        button     : {
                            text : vnode.context.attributes.buttons.add
                        },
                        upbOptions : {
                            size : vnode.context.attributes.size
                        },
                        state      : 'upb-image-media',
                        states     : [
                            new wp.media.controller.Library({
                                id              : 'upb-image-media',
                                title           : vnode.context.attributes.title,
                                library         : wp.media.query({type : 'image'}),
                                multiple        : false,
                                date            : false,
                                displaySettings : true, // to display ATTACHMENT DISPLAY SETTINGS,
                            })
                        ]
                    });

                    // set up our select handler
                    frame.on('select', function () {

                        // http://stackoverflow.com/questions/21540951/custom-wp-media-with-arguments-support

                        let selection = frame.state().get('selection');

                        let state = frame.state('upb-image-media');

                        if (!selection) return;

                        // loop through the selected files
                        selection.each(function (attachment) {

                            let display        = state.display(attachment).toJSON();
                            let obj_attachment = attachment.toJSON();

                            display = wp.media.string.props(display, obj_attachment);

                            /*if (_.isUndefined(attachment.attributes.sizes[vnode.context.attributes.size])) {
                             console.warn(`Media Image size "${vnode.context.attributes.size}" is not available, try re-generate thumbnails. Did you add your image size with "image_size_names_choose" filter? Now Using full sized for fallback. Available sizes are:`)
                             console.table(attachment.attributes.sizes);
                             vnode.context.attributes.size = 'full';
                             }*/

                            let src = display.src;
                            let id  = attachment.id;

                            if (!vnode.context.onSelect) {
                                util.warn(`You need to implement the "onSelect" method`, vnode.context);
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