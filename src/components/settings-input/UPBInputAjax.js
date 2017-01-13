import store from '../../store'
import common from './common'
import extend from 'extend'
import {sprintf} from 'sprintf-js';

import Select2 from '../../plugins/vue-select2'

import userInputMixin from './user-mixins'

Vue.use(Select2);

export default {
    name   : 'upb-input-ajax',

    mixins : [common, userInputMixin('ajax')],

    computed : {

        settings(){

            let settings = {
                ajax               : {
                    cache          : true,
                    url            : this.l10n.ajaxUrl,
                    dataType       : 'json',
                    data           : params => {
                        return {
                            action : this.attributes.hooks.ajax,
                            query  : params.term, // search query
                            _nonce : store.getNonce(),
                        };
                    },
                    processResults : function (result, params) {

                        return {
                            results : result.data,
                        };
                    }
                },
                minimumInputLength : 3,

                templateResult    : state => this.template(state),
                templateSelection : state => this.template(state),
                escapeMarkup      : markup => markup,
            };

            return extend(true, settings, this.attributes.settings);

        }
    },

    methods : {

        template(data){

            if (!data.id || data.loading) {
                return data.text;
            }

            // Template format should be like: "<div> ID# %(id)s - %(title)s</div>"
            // And always should an id not ID ( capital )

            if (_.isUndefined(this.attributes['template'])) {
                return `<div> ID# ${data.id} - ${data.title}</div>`;
            }
            else {
                return sprintf(this.attributes.template, data);
            }
        },

        onChange(data, e){
            this.input = data.id;

            this.attributes.options.id    = data.id;
            this.attributes.options.title = data.title;
            this.attributes.options.text  = data.text;
        },

        onRemove(data){
            Vue.set(this, 'input', '');

            this.attributes.options.id    = '';
            this.attributes.options.title = '';
            this.attributes.options.text  = '';
        }
    }
}