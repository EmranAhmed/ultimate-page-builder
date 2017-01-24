import store from '../../store'
import common from './common'
import extend from 'extend'
import {sprintf} from 'sprintf-js';

import Select2 from '../../plugins/vue-select2'

import userInputMixin from './user-mixins'

Vue.use(Select2);

export default {
    name : 'upb-input-ajax',

    mixins : [common, userInputMixin('ajax')],

    computed : {

        settings(){

            let settings = {
                multiple           : this.multiple,
                ajax               : {
                    cache          : true,
                    url            : this.l10n.ajaxUrl,
                    dataType       : 'json',
                    data           : params => {
                        return {
                            action   : this.attributes.hooks.search,
                            query    : params.term, // search query
                            search   : params.term, // search query
                            multiple : this.multiple,
                            _nonce   : store.getNonce(),
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
            id       : this.input,
            ids      : this.input,
            load     : this.input,
            multiple : this.multiple,
        }, options=> {

            if (this.multiple) {
                Vue.set(this.attributes, 'options', extend(true, [], options));
            }
            else {
                Vue.set(this.attributes, 'options', extend(true, {}, options));
            }

        }, e => {
            console.log(`Did you add "${this.attributes.hooks.load}" action?`, e);
        })
    },

    methods : {

        template(data){

            if (!data.id || data.loading) {
                return data.text;
            }

            // Template format should be like: "<div> ID# %(id)s - %(title)s</div>"
            // And always should an id ( small ) not ID ( capital )

            if (_.isUndefined(this.attributes['template'])) {
                return `<div> ID# ${data.id} - ${data.title}</div>`;
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

        onRemove(data, event){

            if (this.multiple) {

                // Need this hack to remove already select item for multiple select2 item
                this.$nextTick(()=> {
                    jQuery(this.$el).find('select > option').each(function (el) {
                        if (jQuery(this).val() == data.id) {
                            jQuery(this).remove();
                        }
                    });
                })

                let id = _.isNumber(data.id) ? data.id.toString() : data.id;
                Vue.set(this, 'input', _.without(this.input, id));
            }
            else {
                Vue.set(this, 'input', '');
            }
        }
    }
}