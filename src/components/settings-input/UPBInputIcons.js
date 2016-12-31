import common from './common'
import extend from 'extend'

import Select2 from '../../plugins/vue-select2'

Vue.use(Select2);

export default {
    name   : 'upb-input-icons',
    props  : ['index', 'target', 'model', 'attributes'], // model[target]
    mixins : [common],

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
            this.input = data.id;
        },

        onRemove(data){
            Vue.set(this, 'input', '');
        }
    }
}