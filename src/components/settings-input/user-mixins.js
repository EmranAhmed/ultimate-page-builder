import store from '../../store'
import extend from 'extend';

export default (inputType = false)=> {
    if (inputType && !_.isUndefined(store.upb_user_inputs_mixin[inputType]) && _.isObject(window[store.upb_user_inputs_mixin[inputType]])) {
        return window[store.upb_user_inputs_mixin[inputType]];
    }
    return {};
}