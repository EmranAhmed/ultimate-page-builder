import extend from 'extend'
import {sprintf} from 'sprintf-js';
import common from './common'
import userInputMixin from './user-mixins'
import Select2 from '../../plugins/vue-select2'

Vue.use(Select2);

export default {
    name     : 'upb-input-icon-select',
    mixins   : [common, userInputMixin('icon-select')],
    computed : {
        settings(){
            let settings = {
                templateResult    : state => this.template(state),
                templateSelection : state => this.template(state),
                escapeMarkup      : markup => markup
            };
            return extend(true, settings, this.attributes.settings);
        }
    },

    methods : {
        template(data){
            if (!data.id) {
                return data.text;
            }

            data.icon = data.element.value;

            if (_.isUndefined(this.attributes['template'])) {
                return `<span class="select2-icon-input"><i class="${data.icon}"></i> ${data.text}</span>`;
            }
            else {
                return sprintf(this.attributes.template, data);
            }
        },

        onChange(data, e){
            Vue.set(this, 'input', data.id.toString());
        },

        onRemove(data){
            Vue.set(this, 'input', '');
        }
    }
}