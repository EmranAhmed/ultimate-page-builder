import common from './common'
import store from '../../store'
import extend from 'extend';

const fieldsComponents = {
    'upb-input-ajax-icon-select'          : require('./UPBInputAjaxIconSelect.vue'),
    'upb-input-ajax-select'               : require('./UPBInputAjaxSelect.vue'),
    'upb-input-background-image'          : require('./UPBInputBackgroundImage.vue'),
    'upb-input-background-image-position' : require('./UPBInputBackgroundImagePosition.vue'),
    'upb-input-checkbox'                  : require('./UPBInputCheckbox.vue'),
    'upb-input-checkbox-icon'             : require('./UPBInputCheckboxIcon.vue'),
    'upb-input-color'                     : require('./UPBInputColor.vue'),
    'upb-input-contents'                  : require('./UPBInputContents.vue'),
    'upb-input-device-hidden'             : require('./UPBInputDeviceHidden.vue'),
    'upb-input-editor'                    : require('./UPBInputEditor.vue'),
    'upb-input-hidden'                    : require('./UPBInputHidden.vue'),
    'upb-input-icon-select'               : require('./UPBInputIconSelect.vue'),
    'upb-input-icon-popup'                : require('./UPBInputIconPopup.vue'),
    'upb-input-media-image'               : require('./UPBInputMediaImage.vue'),
    'upb-input-message'                   : require('./UPBInputMessage.vue'),
    'upb-input-number'                    : require('./UPBInputNumber.vue'),
    'upb-input-radio'                     : require('./UPBInputRadio.vue'),
    'upb-input-radio-icon'                : require('./UPBInputRadioIcon.vue'),
    'upb-input-radio-image'               : require('./UPBInputRadioImage.vue'),
    'upb-input-range'                     : require('./UPBInputRange.vue'),
    'upb-input-spacing'                   : require('./UPBInputSpacing.vue'),
    'upb-input-select'                    : require('./UPBInputSelect.vue'),
    'upb-input-select2'                   : require('./UPBInputSelect2.vue'),
    'upb-input-select2-icon'              : require('./UPBInputSelect2Icon.vue'),
    'upb-input-text'                      : require('./UPBInputText.vue'),
    'upb-input-textarea'                  : require('./UPBInputTextarea.vue'),
    'upb-input-toggle'                    : require('./UPBInputToggle.vue'),
};

Object.keys(fieldsComponents).map((key) => {
    if (_.isObject(fieldsComponents[key])) {
        // Vue.component(key, fieldsComponents[key])
    }
});

if (_.isArray(store.fields) && !_.isEmpty(store.fields)) {
    store.fields.map(input=> {

        if (!_.isUndefined(input['component']) && !_.isUndefined(input['name'])) {

            // Input mixin
            let userInputMixin = {};
            let mixinName      = store.upb_user_inputs_mixin[input.name];

            if (!_.isUndefined(store.upb_user_inputs_mixin[input.name]) && _.isObject(window[mixinName])) {
                userInputMixin = extend(true, {}, window[mixinName]);
            }

            fieldsComponents[`upb-input-${input.name}`] = extend(true, {
                mixins : [common, userInputMixin]
            }, window[input.component] || {});
        }
        // Vue.component(`upb-input-${input.name}`, fieldsComponent[`upb-input-${input.name}`])
    });
}

export default fieldsComponents