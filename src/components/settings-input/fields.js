import common from "./common";
import store from "../../store";
import extend from "extend";

const fieldsComponents = {
    'upb-input-ajax-icon-select'          : () => import(/* webpackChunkName: "upb-input-ajax-icon-select" */ './UPBInputAjaxIconSelect.vue'),
    'upb-input-ajax-select'               : () => import(/* webpackChunkName: "upb-input-ajax-select" */ './UPBInputAjaxSelect.vue'),
    'upb-input-background-image'          : () => import(/* webpackChunkName: "upb-input-background-image" */ './UPBInputBackgroundImage.vue'),
    'upb-input-background-image-position' : () => import(/* webpackChunkName: "upb-input-background-image-position" */ './UPBInputBackgroundImagePosition.vue'),
    'upb-input-checkbox'                  : () => import(/* webpackChunkName: "upb-input-checkbox" */ './UPBInputCheckbox.vue'),
    'upb-input-checkbox-icon'             : () => import(/* webpackChunkName: "upb-input-checkbox-icon" */ './UPBInputCheckboxIcon.vue'),
    'upb-input-color'                     : () => import(/* webpackChunkName: "upb-input-color" */ './UPBInputColor.vue'),
    'upb-input-contents'                  : () => import(/* webpackChunkName: "upb-input-contents" */ './UPBInputContents.vue'),
    'upb-input-device-hidden'             : () => import(/* webpackChunkName: "upb-input-device-hidden" */ './UPBInputDeviceHidden.vue'),
    'upb-input-editor'                    : () => import(/* webpackChunkName: "upb-input-editor" */'./UPBInputEditor.vue'),
    'upb-input-hidden'                    : () => import(/* webpackChunkName: "upb-input-hidden" */ './UPBInputHidden.vue'),
    'upb-input-icon-select'               : () => import(/* webpackChunkName: "upb-input-icon-select" */ './UPBInputIconSelect.vue'),
    'upb-input-icon-popup'                : () => import(/* webpackChunkName: "upb-input-icon-popup" */ './UPBInputIconPopup.vue'),
    'upb-input-media-image'               : () => import(/* webpackChunkName: "upb-input-media-image" */ './UPBInputMediaImage.vue'),
    'upb-input-message'                   : () => import(/* webpackChunkName: "upb-input-message" */ './UPBInputMessage.vue'),
    'upb-input-heading'                   : () => import(/* webpackChunkName: "upb-input-heading" */ './UPBInputHeading.vue'),
    'upb-input-number'                    : () => import(/* webpackChunkName: "upb-input-number" */ './UPBInputNumber.vue'),
    'upb-input-radio'                     : () => import(/* webpackChunkName: "upb-input-radio" */ './UPBInputRadio.vue'),
    'upb-input-radio-icon'                : () => import(/* webpackChunkName: "upb-input-radio-icon" */ './UPBInputRadioIcon.vue'),
    'upb-input-radio-image'               : () => import(/* webpackChunkName: "upb-input-radio-image" */ './UPBInputRadioImage.vue'),
    'upb-input-range'                     : () => import(/* webpackChunkName: "upb-input-range" */ './UPBInputRange.vue'),
    'upb-input-spacing'                   : () => import(/* webpackChunkName: "upb-input-spacing" */ './UPBInputSpacing.vue'),
    'upb-input-select'                    : () => import(/* webpackChunkName: "upb-input-select" */ './UPBInputSelect.vue'),
    'upb-input-select2'                   : () => import(/* webpackChunkName: "upb-input-select2" */ './UPBInputSelect2.vue'),
    'upb-input-select2-icon'              : () => import(/* webpackChunkName: "upb-input-select2-icon" */ './UPBInputSelect2Icon.vue'),
    'upb-input-text'                      : () => import(/* webpackChunkName: "upb-input-text" */ './UPBInputText.vue'),
    'upb-input-textarea'                  : () => import(/* webpackChunkName: "upb-input-textarea" */ './UPBInputTextarea.vue'),
    'upb-input-toggle'                    : () => import(/* webpackChunkName: "upb-input-toggle" */ './UPBInputToggle.vue'),
};

Object.keys(fieldsComponents).map((key) => {
    if (_.isObject(fieldsComponents[key])) {
        // Vue.component(key, fieldsComponents[key])
    }
});

if (_.isArray(store.fields) && !_.isEmpty(store.fields)) {
    store.fields.map(input => {

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