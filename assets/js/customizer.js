(function (api, wp, $) {

    'use strict';

    let component;

    if (!api.UltimatePageBuilder) {
        api.UltimatePageBuilder = {};
    }

    component = api.UltimatePageBuilder;
    //alreadyFetchedPosts = {}; // id : {...settings}

    class UltimatePageBuilder {

        constructor() {
            this.previewedQuery = new api.Value();
            this.previewedQuery.set({});
        }

        fetchPostData(data) {

            this.previewedQuery.set(data);

            // console.log(this.previewedQuery.get().id);

            this.fetchPost(this.previewedQuery.get().id).then(data => {

                console.log(data);
                data.map(function (setting_id) {
                    api.control(setting_id).active(true);
                });
                //api.control('upb[11][enable]').active(true)
            });

            //console.log(UltimatePageBuilder.alreadyGeneratedPostSettings);
        }

        fetchPost(post_id) {

            return new Promise((resolve, reject) => {

                console.log(`Has id ${ post_id } : `, this.hasAlreadyGeneratedPostSettings(post_id));

                if (this.hasAlreadyGeneratedPostSettings(post_id)) {
                    return resolve(this.getAlreadyGeneratedPostSettings(post_id));
                }

                wp.ajax.post('upb-fetch-settings', {
                    'upb-page-builder-nonce': api.settings.nonce['upb-page-builder'],
                    'wp_customize': 'on',
                    'customized': api.previewer.query().customized,
                    'post_id': post_id
                }).done(settings => {

                    this.setAlreadyGeneratedPostSettings(post_id, Object.keys(settings));

                    this.createSettings(settings);

                    //resolve(this.getAlreadyGeneratedPostSettings(post_id));
                    resolve(this.getAlreadyGeneratedPostSettings(post_id));
                }).fail((jqXHR, textStatus) => {
                    reject(`Request failed:  ${ textStatus } on ID: ${ post_id }`);
                });
            });

            //console.log(api.previewer.query().customized);
        }

        parseSettingId(settingId) {
            var parsed = {},
                idParts;
            idParts = settingId.replace(/]/g, '').split('[');

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
        }

        addEnableControl(section_id, setting_id) {
            let control;

            if (api.control.has(setting_id)) {
                return api.control(setting_id);
            }

            control = new api.controlConstructor['upb-control'](setting_id, {
                params: {
                    section: section_id,
                    priority: 10,
                    label: 'Enable',
                    active: false,
                    settings: {
                        'default': setting_id
                    },
                    field_type: 'text',
                    input_attrs: {
                        'data-customize-setting-link': setting_id
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

                let setting,
                    matches,
                    parsedSettingId = this.parseSettingId(id),
                    SettingConstructor,
                    settingParams;

                // on change add post id to changed post id and will not generate data from when page refresh

                setting = api(id);

                if (!setting) {
                    SettingConstructor = api.settingConstructor[settingArgs.type] || api.Setting;
                    settingParams = _.extend({}, settingArgs, {
                        previewer: api.previewer,
                        dirty: false
                    });
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
                    api.previewer.send('customize-upb-setting', _.extend({ id: id }, settingArgs));
                }
            });
        }

        hasAlreadyGeneratedPostSettings(post_id) {

            let has_post_settings = Object.keys(UltimatePageBuilder.alreadyGeneratedPostSettings).filter(id => post_id == id);

            return has_post_settings.length > 0;
        }

        getAlreadyGeneratedPostSettings(post_id) {
            return UltimatePageBuilder.alreadyGeneratedPostSettings[post_id];
        }

        setAlreadyGeneratedPostSettings(post_id, settings) {
            UltimatePageBuilder.alreadyGeneratedPostSettings[post_id] = settings;
        }

    }

    UltimatePageBuilder.alreadyGeneratedPostSettings = {};
    api.bind('ready', () => {
        component = new UltimatePageBuilder();
        api.previewer.bind('_upb_page_data', data => {
            component.fetchPostData(data);
        });
    });
})(wp.customize, wp, jQuery);
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImN1c3RvbWl6ZXIuanMiXSwibmFtZXMiOlsiYXBpIiwid3AiLCIkIiwiY29tcG9uZW50IiwiVWx0aW1hdGVQYWdlQnVpbGRlciIsImNvbnN0cnVjdG9yIiwicHJldmlld2VkUXVlcnkiLCJWYWx1ZSIsInNldCIsImZldGNoUG9zdERhdGEiLCJkYXRhIiwiZmV0Y2hQb3N0IiwiZ2V0IiwiaWQiLCJ0aGVuIiwiY29uc29sZSIsImxvZyIsIm1hcCIsInNldHRpbmdfaWQiLCJjb250cm9sIiwiYWN0aXZlIiwicG9zdF9pZCIsIlByb21pc2UiLCJyZXNvbHZlIiwicmVqZWN0IiwiaGFzQWxyZWFkeUdlbmVyYXRlZFBvc3RTZXR0aW5ncyIsImdldEFscmVhZHlHZW5lcmF0ZWRQb3N0U2V0dGluZ3MiLCJhamF4IiwicG9zdCIsInNldHRpbmdzIiwibm9uY2UiLCJwcmV2aWV3ZXIiLCJxdWVyeSIsImN1c3RvbWl6ZWQiLCJkb25lIiwic2V0QWxyZWFkeUdlbmVyYXRlZFBvc3RTZXR0aW5ncyIsIk9iamVjdCIsImtleXMiLCJjcmVhdGVTZXR0aW5ncyIsImZhaWwiLCJqcVhIUiIsInRleHRTdGF0dXMiLCJwYXJzZVNldHRpbmdJZCIsInNldHRpbmdJZCIsInBhcnNlZCIsImlkUGFydHMiLCJyZXBsYWNlIiwic3BsaXQiLCJzZXR0aW5nVHlwZSIsImxlbmd0aCIsInBvc3RJZCIsInBhcnNlSW50IiwiaXNOYU4iLCJtZXRhS2V5IiwiYWRkRW5hYmxlQ29udHJvbCIsInNlY3Rpb25faWQiLCJoYXMiLCJjb250cm9sQ29uc3RydWN0b3IiLCJwYXJhbXMiLCJzZWN0aW9uIiwicHJpb3JpdHkiLCJsYWJlbCIsImZpZWxkX3R5cGUiLCJpbnB1dF9hdHRycyIsImFkZCIsIl8iLCJlYWNoIiwic2V0dGluZ0FyZ3MiLCJzZXR0aW5nIiwibWF0Y2hlcyIsInBhcnNlZFNldHRpbmdJZCIsIlNldHRpbmdDb25zdHJ1Y3RvciIsInNldHRpbmdQYXJhbXMiLCJzZXR0aW5nQ29uc3RydWN0b3IiLCJ0eXBlIiwiU2V0dGluZyIsImV4dGVuZCIsImRpcnR5IiwidmFsdWUiLCJfZGlydHkiLCJjYWxsYmFja3MiLCJmaXJlV2l0aCIsInNlbmQiLCJoYXNfcG9zdF9zZXR0aW5ncyIsImFscmVhZHlHZW5lcmF0ZWRQb3N0U2V0dGluZ3MiLCJmaWx0ZXIiLCJiaW5kIiwiY3VzdG9taXplIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiQUFBQSxDQUFDLFVBQVVBLEdBQVYsRUFBZUMsRUFBZixFQUFtQkMsQ0FBbkIsRUFBc0I7O0FBRW5COztBQUVBLFFBQUlDLFNBQUo7O0FBRUEsUUFBSSxDQUFDSCxJQUFJSSxtQkFBVCxFQUE4QjtBQUMxQkosWUFBSUksbUJBQUosR0FBMEIsRUFBMUI7QUFDSDs7QUFFREQsZ0JBQVlILElBQUlJLG1CQUFoQjtBQUNBOztBQUVBLFVBQU1BLG1CQUFOLENBQTBCOztBQUl0QkMsc0JBQWM7QUFDVixpQkFBS0MsY0FBTCxHQUFzQixJQUFJTixJQUFJTyxLQUFSLEVBQXRCO0FBQ0EsaUJBQUtELGNBQUwsQ0FBb0JFLEdBQXBCLENBQXdCLEVBQXhCO0FBQ0g7O0FBRURDLHNCQUFjQyxJQUFkLEVBQW9COztBQUVoQixpQkFBS0osY0FBTCxDQUFvQkUsR0FBcEIsQ0FBd0JFLElBQXhCOztBQUVBOztBQUVBLGlCQUFLQyxTQUFMLENBQWUsS0FBS0wsY0FBTCxDQUFvQk0sR0FBcEIsR0FBMEJDLEVBQXpDLEVBQ0tDLElBREwsQ0FDV0osSUFBRCxJQUFVOztBQUVaSyx3QkFBUUMsR0FBUixDQUFZTixJQUFaO0FBQ0FBLHFCQUFLTyxHQUFMLENBQVMsVUFBVUMsVUFBVixFQUFzQjtBQUMzQmxCLHdCQUFJbUIsT0FBSixDQUFZRCxVQUFaLEVBQXdCRSxNQUF4QixDQUErQixJQUEvQjtBQUNILGlCQUZEO0FBR0E7QUFFSCxhQVRMOztBQVdBO0FBRUg7O0FBRURULGtCQUFVVSxPQUFWLEVBQW1COztBQUVmLG1CQUFPLElBQUlDLE9BQUosQ0FBWSxDQUFDQyxPQUFELEVBQVVDLE1BQVYsS0FBb0I7O0FBRW5DVCx3QkFBUUMsR0FBUixDQUFhLFdBQVNLLE9BQVEsTUFBOUIsRUFBb0MsS0FBS0ksK0JBQUwsQ0FBcUNKLE9BQXJDLENBQXBDOztBQUVBLG9CQUFJLEtBQUtJLCtCQUFMLENBQXFDSixPQUFyQyxDQUFKLEVBQW1EO0FBQy9DLDJCQUFPRSxRQUFRLEtBQUtHLCtCQUFMLENBQXFDTCxPQUFyQyxDQUFSLENBQVA7QUFDSDs7QUFFRHBCLG1CQUFHMEIsSUFBSCxDQUFRQyxJQUFSLENBQWEsb0JBQWIsRUFBbUM7QUFDM0IsOENBQTJCNUIsSUFBSTZCLFFBQUosQ0FBYUMsS0FBYixDQUFtQixrQkFBbkIsQ0FEQTtBQUUzQixvQ0FBMkIsSUFGQTtBQUczQixrQ0FBMkI5QixJQUFJK0IsU0FBSixDQUFjQyxLQUFkLEdBQXNCQyxVQUh0QjtBQUkzQiwrQkFBMkJaO0FBSkEsaUJBQW5DLEVBT0thLElBUEwsQ0FPV0wsUUFBRCxJQUFjOztBQUVoQix5QkFBS00sK0JBQUwsQ0FBcUNkLE9BQXJDLEVBQThDZSxPQUFPQyxJQUFQLENBQVlSLFFBQVosQ0FBOUM7O0FBRUEseUJBQUtTLGNBQUwsQ0FBb0JULFFBQXBCOztBQUVBO0FBQ0FOLDRCQUFRLEtBQUtHLCtCQUFMLENBQXFDTCxPQUFyQyxDQUFSO0FBRUgsaUJBaEJMLEVBa0JLa0IsSUFsQkwsQ0FrQlUsQ0FBQ0MsS0FBRCxFQUFRQyxVQUFSLEtBQXVCO0FBQ3pCakIsMkJBQVEscUJBQW1CaUIsVUFBVyxhQUFVcEIsT0FBUSxHQUF4RDtBQUNILGlCQXBCTDtBQXNCSCxhQTlCTSxDQUFQOztBQWdDQTtBQUVIOztBQUVEcUIsdUJBQWVDLFNBQWYsRUFBMEI7QUFDdEIsZ0JBQUlDLFNBQVMsRUFBYjtBQUFBLGdCQUFpQkMsT0FBakI7QUFDQUEsc0JBQWFGLFVBQVVHLE9BQVYsQ0FBa0IsSUFBbEIsRUFBd0IsRUFBeEIsRUFBNEJDLEtBQTVCLENBQWtDLEdBQWxDLENBQWI7O0FBRUEsZ0JBQUksVUFBVUYsUUFBUSxDQUFSLENBQWQsRUFBMEI7QUFDdEIsdUJBQU8sSUFBUDtBQUNIOztBQUVERCxtQkFBT0ksV0FBUCxHQUFxQkgsUUFBUSxDQUFSLENBQXJCO0FBQ0EsZ0JBQUksVUFBVUQsT0FBT0ksV0FBakIsSUFBZ0MsTUFBTUgsUUFBUUksTUFBbEQsRUFBMEQ7QUFDdEQsdUJBQU8sSUFBUDtBQUNIOztBQUVETCxtQkFBT00sTUFBUCxHQUFnQkMsU0FBU04sUUFBUSxDQUFSLENBQVQsRUFBcUIsRUFBckIsQ0FBaEI7QUFDQSxnQkFBSU8sTUFBTVIsT0FBT00sTUFBYixLQUF3Qk4sT0FBT00sTUFBUCxJQUFpQixDQUE3QyxFQUFnRDtBQUM1Qyx1QkFBTyxJQUFQO0FBQ0g7O0FBRUQsZ0JBQUksVUFBVU4sT0FBT0ksV0FBckIsRUFBa0M7QUFDOUJKLHVCQUFPUyxPQUFQLEdBQWlCUixRQUFRLENBQVIsQ0FBakI7QUFDQSxvQkFBSSxDQUFDRCxPQUFPUyxPQUFaLEVBQXFCO0FBQ2pCLDJCQUFPLElBQVA7QUFDSDtBQUNKOztBQUVELG1CQUFPVCxNQUFQO0FBQ0g7O0FBRURVLHlCQUFpQkMsVUFBakIsRUFBNkJyQyxVQUE3QixFQUF5QztBQUNyQyxnQkFBSUMsT0FBSjs7QUFFQSxnQkFBSW5CLElBQUltQixPQUFKLENBQVlxQyxHQUFaLENBQWdCdEMsVUFBaEIsQ0FBSixFQUFpQztBQUM3Qix1QkFBT2xCLElBQUltQixPQUFKLENBQVlELFVBQVosQ0FBUDtBQUNIOztBQUVEQyxzQkFBVSxJQUFJbkIsSUFBSXlELGtCQUFKLENBQXVCLGFBQXZCLENBQUosQ0FBMEN2QyxVQUExQyxFQUFzRDtBQUM1RHdDLHdCQUFTO0FBQ0xDLDZCQUFjSixVQURUO0FBRUxLLDhCQUFjLEVBRlQ7QUFHTEMsMkJBQWMsUUFIVDtBQUlMekMsNEJBQWMsS0FKVDtBQUtMUyw4QkFBYztBQUNWLG1DQUFZWDtBQURGLHFCQUxUO0FBUUw0QyxnQ0FBYyxNQVJUO0FBU0xDLGlDQUFjO0FBQ1YsdURBQWdDN0M7QUFEdEI7QUFUVDtBQURtRCxhQUF0RCxDQUFWOztBQWdCQTs7QUFFQTtBQUNBbEIsZ0JBQUltQixPQUFKLENBQVk2QyxHQUFaLENBQWdCN0MsUUFBUU4sRUFBeEIsRUFBNEJNLE9BQTVCOztBQUVBLG1CQUFPQSxPQUFQO0FBQ0g7O0FBRURtQix1QkFBZVQsUUFBZixFQUF5QlIsT0FBekIsRUFBa0M7O0FBRTlCNEMsY0FBRUMsSUFBRixDQUFPckMsUUFBUCxFQUFpQixDQUFDc0MsV0FBRCxFQUFjdEQsRUFBZCxLQUFxQjs7QUFFbEMsb0JBQUl1RCxPQUFKO0FBQUEsb0JBQWFDLE9BQWI7QUFBQSxvQkFBc0JDLGtCQUFrQixLQUFLNUIsY0FBTCxDQUFvQjdCLEVBQXBCLENBQXhDO0FBQUEsb0JBQWlFMEQsa0JBQWpFO0FBQUEsb0JBQXFGQyxhQUFyRjs7QUFFQTs7QUFFQUosMEJBQVVwRSxJQUFJYSxFQUFKLENBQVY7O0FBRUEsb0JBQUksQ0FBQ3VELE9BQUwsRUFBYztBQUNWRyx5Q0FBcUJ2RSxJQUFJeUUsa0JBQUosQ0FBdUJOLFlBQVlPLElBQW5DLEtBQTRDMUUsSUFBSTJFLE9BQXJFO0FBQ0FILG9DQUFxQlAsRUFBRVcsTUFBRixDQUFTLEVBQVQsRUFBYVQsV0FBYixFQUEwQjtBQUN2Q3BDLG1DQUFZL0IsSUFBSStCLFNBRHVCO0FBRXZDOEMsK0JBQVk7QUFGMkIscUJBQTFCLENBQXJCO0FBS0EsMkJBQU9MLGNBQWNNLEtBQXJCO0FBQ0FWLDhCQUFVLElBQUlHLGtCQUFKLENBQXVCMUQsRUFBdkIsRUFBMkJzRCxZQUFZVyxLQUF2QyxFQUE4Q04sYUFBOUMsQ0FBVjtBQUNBeEUsd0JBQUlnRSxHQUFKLENBQVFuRCxFQUFSLEVBQVl1RCxPQUFaOztBQUVBO0FBQ0Esd0JBQUlELFlBQVlVLEtBQWhCLEVBQXVCO0FBQ25CVCxnQ0FBUVcsTUFBUixHQUFpQixJQUFqQjtBQUNBWCxnQ0FBUVksU0FBUixDQUFrQkMsUUFBbEIsQ0FBMkJiLE9BQTNCLEVBQW9DLENBQUNBLFFBQVF4RCxHQUFSLEVBQUQsRUFBZ0J3RCxRQUFReEQsR0FBUixFQUFoQixDQUFwQztBQUNIOztBQUVEO0FBQ0EseUJBQUswQyxnQkFBTCxDQUFzQixrQkFBdEIsRUFBMEN6QyxFQUExQztBQUNBOztBQUVBOzs7OztBQUtBYix3QkFBSStCLFNBQUosQ0FBY21ELElBQWQsQ0FBbUIsdUJBQW5CLEVBQTRDakIsRUFBRVcsTUFBRixDQUFTLEVBQUMvRCxJQUFLQSxFQUFOLEVBQVQsRUFBb0JzRCxXQUFwQixDQUE1QztBQUNIO0FBRUosYUFyQ0Q7QUF1Q0g7O0FBRUQxQyx3Q0FBZ0NKLE9BQWhDLEVBQXlDOztBQUVyQyxnQkFBSThELG9CQUFvQi9DLE9BQU9DLElBQVAsQ0FBWWpDLG9CQUFvQmdGLDRCQUFoQyxFQUE4REMsTUFBOUQsQ0FBc0V4RSxFQUFELElBQVFRLFdBQVdSLEVBQXhGLENBQXhCOztBQUVBLG1CQUFPc0Usa0JBQWtCbEMsTUFBbEIsR0FBMkIsQ0FBbEM7QUFFSDs7QUFFRHZCLHdDQUFnQ0wsT0FBaEMsRUFBeUM7QUFDckMsbUJBQU9qQixvQkFBb0JnRiw0QkFBcEIsQ0FBaUQvRCxPQUFqRCxDQUFQO0FBQ0g7O0FBRURjLHdDQUFnQ2QsT0FBaEMsRUFBeUNRLFFBQXpDLEVBQW1EO0FBQy9DekIsZ0NBQW9CZ0YsNEJBQXBCLENBQWlEL0QsT0FBakQsSUFBNERRLFFBQTVEO0FBQ0g7O0FBeExxQjs7QUFBcEJ6Qix1QkFiYSxDQWVSZ0YsNEJBZlEsR0FldUIsRUFmdkI7QUF5TW5CcEYsUUFBSXNGLElBQUosQ0FBUyxPQUFULEVBQWtCLE1BQU07QUFDcEJuRixvQkFBWSxJQUFJQyxtQkFBSixFQUFaO0FBQ0FKLFlBQUkrQixTQUFKLENBQWN1RCxJQUFkLENBQW1CLGdCQUFuQixFQUFzQzVFLElBQUQsSUFBUztBQUMxQ1Asc0JBQVVNLGFBQVYsQ0FBd0JDLElBQXhCO0FBQ0gsU0FGRDtBQUdILEtBTEQ7QUFPSCxDQWhORCxFQWdOR1QsR0FBR3NGLFNBaE5OLEVBZ05pQnRGLEVBaE5qQixFQWdOcUJ1RixNQWhOckIiLCJmaWxlIjoiY3VzdG9taXplci5qcyJ9
