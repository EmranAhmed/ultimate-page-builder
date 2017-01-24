import store from '../../store'
import common from './common'
import extend from 'extend'
import {sprintf} from 'sprintf-js';

import userInputMixin from './user-mixins'

import Select2 from '../../plugins/vue-select2'

Vue.use(Select2);

export default {
    name   : 'upb-input-icon-ajax',
    mixins : [common, userInputMixin('icon-ajax')],

    computed : {

        settings(){

            let settings = {
                ajax               : {
                    cache          : true,
                    url            : this.l10n.ajaxUrl,
                    dataType       : 'json',
                    data           : params => {
                        return {
                            action : this.attributes.hooks.search,
                            query  : params.term, // search query
                            search : params.term, // search query
                            _nonce : store.getNonce()
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
        },

        options(){
            return this.attributes.options
        }
    },

    created(){
        store.wpAjax(this.attributes.hooks.load, {
            id   : this.input,
            ids  : this.input,
            load : this.input
        }, options=> {
            Vue.set(this.attributes, 'options', extend(true, {}, options));
        }, e => {
            console.log(`Did you add "${this.attributes.hooks.load}" action?`, e);
        })
    },

    methods : {

        template(data){

            if (!data.id || data.loading) {
                return data.text;
            }

            // Template format should be like: "<span class="select2-icon-input"><i class="%(id)s"></i>  %(title)s</div>"
            // And always should an id ( small ) not ID ( capital )

            // return jQuery(`<span class="select2-icon-input"><i class="${state.element.value}"></i> &nbsp; ${state.text}</span>`);
            if (_.isUndefined(this.attributes['template'])) {
                return `<span class="select2-icon-input"><i class="${data.id}"></i>  ${data.title}</span>`;
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