(function (api, wp, $) {

    'use strict';

    let component;

    if (!api.UltimatePageBuilder) {
        api.UltimatePageBuilder = {};
    }

    component = api.UltimatePageBuilder;
    //alreadyFetchedPosts = {}; // id : {...settings}

    class UltimatePageBuilder {

        static alreadyGeneratedPostSettings = {};

        constructor() {
            this.previewedQuery = new api.Value();
            this.previewedQuery.set({});
        }

        fetchPostData(data) {

            this.previewedQuery.set(data);

            // console.log(this.previewedQuery.get().id);

            this.fetchPost(this.previewedQuery.get().id)
                .then((data) => {

                    console.log(data);
                    data.map(function (setting_id) {
                        api.control(setting_id).active(true);
                    })
                    //api.control('upb[11][enable]').active(true)

                })

            //console.log(UltimatePageBuilder.alreadyGeneratedPostSettings);

        }

        fetchPost(post_id) {

            return new Promise((resolve, reject)=> {

                console.log(`Has id ${post_id} : `, this.hasAlreadyGeneratedPostSettings(post_id));

                if (this.hasAlreadyGeneratedPostSettings(post_id)) {
                    return resolve(this.getAlreadyGeneratedPostSettings(post_id));
                }

                wp.ajax.post('upb-fetch-settings', {
                        'upb-page-builder-nonce' : api.settings.nonce['upb-page-builder'],
                        'wp_customize'           : 'on',
                        'customized'             : api.previewer.query().customized,
                        'post_id'                : post_id
                    })

                    .done((settings) => {

                        this.setAlreadyGeneratedPostSettings(post_id, Object.keys(settings))

                        this.createSettings(settings);

                        //resolve(this.getAlreadyGeneratedPostSettings(post_id));
                        resolve(this.getAlreadyGeneratedPostSettings(post_id));

                    })

                    .fail((jqXHR, textStatus) => {
                        reject(`Request failed:  ${textStatus} on ID: ${post_id}`)
                    })

            })

            //console.log(api.previewer.query().customized);

        }

        parseSettingId(settingId) {
            var parsed = {}, idParts;
            idParts    = settingId.replace(/]/g, '').split('[');

            if ('upb' !== idParts[0]) {
                return null;
            }

            parsed.settingType = idParts[0];
            if ('upb' === parsed.settingType && 3 !== idParts.length) {
                return null;
            }

            parsed.postId = parseInt(idParts[1], 10);
            if (isNaN(parsed.postId) || parsed.postId <= 0) {
                return null;
            }

            if ('upb' === parsed.settingType) {
                parsed.metaKey = idParts[2];
                if (!parsed.metaKey) {
                    return null;
                }
            }

            return parsed;
        };

        addEnableControl(section_id, setting_id) {
            let control;

            if (api.control.has(setting_id)) {
                return api.control(setting_id);
            }

            control = new api.controlConstructor['upb-control'](setting_id, {
                params : {
                    section     : section_id,
                    priority    : 10,
                    label       : 'Enable',
                    active      : false,
                    settings    : {
                        'default' : setting_id
                    },
                    field_type  : 'text',
                    input_attrs : {
                        'data-customize-setting-link' : setting_id
                    }
                }
            });

            // post_id

            ///control.active.set( true );
            api.control.add(control.id, control);

            return control;
        }

        createSettings(settings, post_id) {

            _.each(settings, (settingArgs, id) => {

                let setting, matches, parsedSettingId = this.parseSettingId(id), SettingConstructor, settingParams;

                // on change add post id to changed post id and will not generate data from when page refresh

                setting = api(id);

                if (!setting) {
                    SettingConstructor = api.settingConstructor[settingArgs.type] || api.Setting;
                    settingParams      = _.extend({}, settingArgs, {
                            previewer : api.previewer,
                            dirty     : false
                        }
                    );
                    delete settingParams.value;
                    setting = new SettingConstructor(id, settingArgs.value, settingParams);
                    api.add(id, setting);

                    // Mark as dirty and trigger change if setting is pre-dirty; see code in wp.customize.Value.prototype.set().
                    if (settingArgs.dirty) {
                        setting._dirty = true;
                        setting.callbacks.fireWith(setting, [setting.get(), setting.get()]);
                    }

                    //////
                    this.addEnableControl('upb-post-section', id);
                    //////

                    /*
                     * Ensure that the setting gets created in the preview as well. When the post/postmeta settings
                     * are sent to the preview, this is the point at which the related selective refresh partials
                     * will also be created.
                     */
                    api.previewer.send('customize-upb-setting', _.extend({id : id}, settingArgs));
                }

            });

        }

        hasAlreadyGeneratedPostSettings(post_id) {

            let has_post_settings = Object.keys(UltimatePageBuilder.alreadyGeneratedPostSettings).filter((id) => post_id == id);

            return has_post_settings.length > 0

        }

        getAlreadyGeneratedPostSettings(post_id) {
            return UltimatePageBuilder.alreadyGeneratedPostSettings[post_id];
        }

        setAlreadyGeneratedPostSettings(post_id, settings) {
            UltimatePageBuilder.alreadyGeneratedPostSettings[post_id] = settings;
        }

    }

    api.bind('ready', () => {
        component = new UltimatePageBuilder();
        api.previewer.bind('_upb_page_data', (data)=> {
            component.fetchPostData(data)
        });
    });

})(wp.customize, wp, jQuery);