import common from './common'
import store from '../../store'
import extend from 'extend';

const fieldsComponents = {

    'upb-input-text'                      : require('./UPBInputText.vue'),
    'upb-input-textarea'                  : require('./UPBInputTextarea.vue'),
    'upb-input-toggle'                    : require('./UPBInputToggle.vue'),
    'upb-input-color'                     : require('./UPBInputColor.vue'),
    'upb-input-select'                    : require('./UPBInputSelect.vue'),
    'upb-input-contents'                  : require('./UPBInputContents.vue'),
    'upb-input-hidden'                    : require('./UPBInputHidden.vue'),
    'upb-input-editor'                    : require('./UPBInputEditor.vue'),
    'upb-input-radio'                     : require('./UPBInputRadio.vue'),
    'upb-input-select2'                   : require('./UPBInputSelect2.vue'),
    'upb-input-icons'                     : require('./UPBInputIcons.vue'),
    'upb-input-icon-ajax'                 : require('./UPBInputIconAjax.vue'),
    'upb-input-ajax'                      : require('./UPBInputAjax.vue'),
    'upb-input-image'                     : require('./UPBInputImage.vue'),
    'upb-input-image-select'              : require('./UPBInputImageSelect.vue'),
    'upb-input-checkbox'                  : require('./UPBInputCheckbox.vue'),
    'upb-input-device-hidden'             : require('./UPBInputHiddenDevice.vue'),
    'upb-input-background-image'          : require('./UPBInputBackgroundImage.vue'),
    'upb-input-background-image-position' : require('./UPBInputBackgroundImagePosition.vue'),
    'upb-input-radio-icon'                : require('./UPBInputRadioIcon.vue'),

};

Object.keys(fieldsComponents).map((key) => {
    if (_.isObject(fieldsComponents[key])) {
        // Vue.component(key, fieldsComponents[key])
    }
});

if (_.isArray(store.fields) && !_.isEmpty(store.fields)) {
    store.fields.map(input=> {

        if (!_.isUndefined(input['component']) && !_.isUndefined(input['name'])) {
            fieldsComponents[`upb-input-${input.name}`] = extend(true, {
                mixins : [common]
            }, window[input.component] || {});
        }

        // Vue.component(`upb-input-${input.name}`, fieldsComponent[`upb-input-${input.name}`])

    });
}

export default fieldsComponents


