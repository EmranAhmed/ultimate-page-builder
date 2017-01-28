import extend from 'extend'
import {sprintf} from 'sprintf-js';
import common from './common'
import userInputMixin from './user-mixins'
import Select2 from '../../plugins/vue-select2'

Vue.use(Select2);

export default {
    name     : 'upb-input-select2-icon',
    mixins   : [common, userInputMixin('select2-icon')],
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
    methods  : {

        template(data){
            if (!data.id) {
                return data.title;
            }

            data.icon = data.element.dataset.icon;

            if (_.isUndefined(this.attributes['template'])) {
                return `<span class="select2-icon-input"><i class="${data.icon}"></i> ${data.title}</span>`;
            }
            else {
                return sprintf(this.attributes.template, data);
            }
        },

        onChange(data, e){

            if (this.multiple) {
                let id = _.isNumber(data.id) ? data.id.toString() : data.id;
                this.input.push(id);
            }
            else {
                Vue.set(this, 'input', data.id.toString());
            }
        },
        onRemove(data){
            if (this.multiple) {
                let id = _.isNumber(data.id) ? data.id.toString() : data.id;
                Vue.set(this, 'input', _.without(this.input, id));
            }
        }
    }
}