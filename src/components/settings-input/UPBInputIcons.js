import common from './common'
import extend from 'extend'
import userInputMixin from './user-mixins'

import Select2 from '../../plugins/vue-select2'

Vue.use(Select2);

export default {
    name   : 'upb-input-icons',
    mixins : [common, userInputMixin('icons')],

    computed : {
        settings(){
            let settings = extend(true, {}, this.attributes.settings);

            settings['templateResult']    = state => this.template(state);
            settings['templateSelection'] = state => this.template(state);
            return settings;
        }
    },

    methods : {

        template(state){
            if (!state.id) {
                return state.text;
            }
            return jQuery(`<span class="select2-icon-input"><i class="${state.element.value}"></i> &nbsp; ${state.text}</span>`);
        },

        onChange(data, e){
            Vue.set(this, 'input', data.id.toString());
        },

        onRemove(data){
            Vue.set(this, 'input', '');
        }
    }
}