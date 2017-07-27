/* global wp, _ */

($ => {

    wp.media.view.MediaFrame.UPBMedia        = wp.media.view.MediaFrame.Select.extend({

        initialize() {

            _.defaults(this.options, {
                className : 'media-frame upb-media-frame',
                title     : wp.media.view.l10n.chooseImage,
                multiple  : false,
                editing   : false,
                // frame     : 'upb-media',
                state     : 'upb-media', // upb-media
                button    : {
                    text : wp.media.view.l10n.addMedia
                },
                metadata  : {}
            });

            // Call 'initialize' directly on the parent class.
            wp.media.view.MediaFrame.Select.prototype.initialize.apply(this, arguments);

        },

        createStates () {

            let options = this.options;

            this.states.add([

                new wp.media.controller.Library({
                    id                  : 'upb-media',
                    title               : options.title,
                    priority            : 20,
                    toolbar             : 'main-insert',
                    filterable          : 'date',
                    library             : wp.media.query(_.defaults(options.library, {
                        type : 'image' // image, audio, video
                    })),
                    multiple            : false,
                    editable            : false,
                    allowLocalEdits     : false,
                    displaySettings     : true,
                    displayUserSettings : false
                }),

                // Embed states.
                new wp.media.controller.Embed({
                    id       : 'upb-embed',
                    title    : wp.media.view.l10n.insertFromUrlTitle,
                    metadata : {
                        url : options.url ? options.url : ''
                    }
                })
            ]);
        },

        bindHandlers () {

            this.on('toolbar:create:main-insert', this.createToolbar, this);
            this.on('toolbar:render:main-insert', this.mainInsertToolbar, this);
            this.on('toolbar:create:main-embed', this.mainEmbedToolbar, this);
            this.on('menu:render:default', this.mainMenu, this);
            this.on('content:render:embed', this.embedContent, this);

            wp.media.view.MediaFrame.Select.prototype.bindHandlers.apply(this, arguments);
        },

        mainMenu (view) {
            view.set({
                'library-separator' : new wp.media.View({
                    className : 'separator',
                    priority  : 100
                })
            });
        },

        embedContent () {

            let view = new wp.media.view.Embed({
                controller : this,
                model      : this.state()
            }).render();

            this.content.set(view);

            if (!wp.media.isTouchDevice) {
                view.url.focus();
            }
        },

        selectionStatusToolbar(view) {

            let editable = this.state().get('editable');

            view.set('selection', new wp.media.view.Selection({
                controller : this,
                collection : this.state().get('selection'),
                priority   : -40
            }).render());
        },

        mainInsertToolbar (view) {
            let controller = this;

            this.selectionStatusToolbar(view);

            view.set('insert', {
                style    : 'primary',
                priority : 80,
                text     : this.options.button.text,
                requires : {selection : true},

                click  () {
                    let state     = controller.state(),
                        selection = state.get('selection');

                    selection.each(function (attachment) {

                        let display = state.display(attachment).toJSON(),
                            object  = attachment.toJSON(),
                            props   = wp.media.string.props(display, object),
                            single  = selection.single();

                        if (props.type == 'image') {
                            single.set('src', props.src);
                        }
                        else {
                            single.set('src', props.linkUrl);
                        }

                    });

                    controller.close();
                    state.trigger('insert', selection).reset();
                }
            });
        },

        mainEmbedToolbar(toolbar) {
            toolbar.view = new wp.media.view.Toolbar.Embed({
                controller : this,
                text       : this.options.button.text,
                event      : 'insert'
            });
        },

    });
    wp.media.view.Settings.AttachmentDisplay = wp.media.view.Settings.AttachmentDisplay.extend({
        template : function (view) {

            let upb_state  = this.controller.state().id;
            let templateId = 'attachment-display-settings';

            // console.log(this.controller.options.upbOptions.size);

            if ('upb-media' == upb_state) {
                // Set Default Size
                this.model.attributes.size = this.controller.options.upbOptions.size;
                templateId                 = 'upb-attachment-display-settings';
            }

            return wp.media.template(templateId)(view);
        }
    });
    wp.media.view.Attachment.Details         = wp.media.view.Attachment.Details.extend({
        template : function (view) {

            let upb_state  = this.controller.state().id;
            let templateId = 'attachment-details';

            if ('upb-media' == upb_state) {
                templateId = 'upb-attachment-details';
            }

            return wp.media.template(templateId)(view);
        }
    })
    wp.media.view.EmbedImage                 = wp.media.view.EmbedImage.extend({
        template : function (view) {

            let upb_state  = this.controller.state().id;
            let templateId = 'embed-image-settings';

            if ('upb-embed' == upb_state) {
                templateId = 'upb-embed-image-settings';
            }

            return wp.media.template(templateId)(view);
        }
    });
    wp.media.view.EmbedLink                  = wp.media.view.EmbedLink.extend({
        template : function (view) {

            let upb_state  = this.controller.state().id;
            let templateId = 'embed-link-settings';

            if ('upb-embed' == upb_state) {
                templateId = 'upb-embed-link-settings';
            }

            return wp.media.template(templateId)(view);
        }
    });
})(jQuery);