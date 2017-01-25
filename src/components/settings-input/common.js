import store from '../../store'

export default{

    props : ['index', 'target', 'model', 'attributes', 'item', 'items', 'keyindexname', 'keyvaluename', 'defaultValue'], // model[target]
    data(){
        return {
            input     : this.model[this.target],
            l10n      : store.l10n,
            showInput : true
        }
    },

    computed : {

        store(){
            return store;
        },

        multiple(){
            return (!_.isUndefined(this.attributes['multiple']) && this.attributes.multiple) ? true : false;
        },

        value(){
            return this.model[this.target];
        },

        useAttributeValue(){
            if (this.attributes.use) {
                return this.getValueOf(this.attributes.use);
            }
        },

        isRequired(){
            return this.showInput;
        }
    },

    watch : {

        input(value, oldValue){
            this.setValue(value);
        },

        value(value, oldValue){
            Vue.set(this, 'input', value);
        },

        items : {
            handler : function (value, oldValue) {
                this.checkRequired();
            },
            deep    : true
        }
    },

    created(){
        // console.log('Common mixin', this.$options._componentTag)
        this.checkRequired();
    },

    methods : {

        checkRequired(){
            if (this.attributes.required) {

                // console.log(this.attributes.title);

                this.showInput = this.attributes.required.every((request)=> {

                    let [id, operator, desireValue] = request;
                    let currentValue = _.isNull(this.getValueOf(id)) ? '' : this.getValueOf(id);

                    switch (operator) {
                        case '=':
                        case '==':

                            if ((_.isBoolean(desireValue) || _.isString(desireValue)) && currentValue == desireValue) {
                                return request;
                            }

                            if ((_.isArray(currentValue) && _.isString(desireValue)) && currentValue.includes(desireValue)) {
                                return request;
                            }

                            if ((_.isString(currentValue) && _.isArray(desireValue)) && desireValue.includes(currentValue)) {
                                return request;
                            }

                            break;
                        case '!=':
                        case '!==':

                            if ((_.isBoolean(desireValue) || _.isString(desireValue)) && currentValue != desireValue) {
                                return request;
                            }

                            if ((_.isArray(currentValue) && _.isString(desireValue)) && !currentValue.includes(desireValue.trim())) {
                                return request;
                            }

                            if ((_.isString(currentValue) && _.isArray(desireValue)) && !desireValue.includes(currentValue.trim())) {
                                return request;
                            }
                            break;
                    }
                });
            }
        },

        getValueOf(key = false){
            if (!_.isEmpty(key)) {

                let find                = {};
                find[this.keyindexname] = key;

                let item = _.findWhere(this.items, find);

                if (!_.isUndefined(item)) {
                    return item[this.keyvaluename];
                }
            }
            return null;
        },

        setValueOf(key, value){

            this.items.map((item, index)=> {

                if (item[this.keyindexname] == key) {

                    // Settings Panel
                    if (!_.isUndefined(item['_upb_field_attrs'])) {
                        Vue.set(item._upb_field_attrs, 'value', value);
                    }

                    // Element Setting
                    if (!_.isUndefined(this.model[key])) {
                        Vue.set(this.model, key, value);
                    }

                    Vue.set(item, this.keyvaluename, value);
                }

            });

        },

        str2Bool(strvalue){
            return (strvalue && typeof strvalue == 'string') ? (strvalue.toLowerCase() == 'true' || strvalue == '1') : (strvalue == true);
        },

        typeClass(){
            return `${this.attributes.type}-field-wrapper form-field-wrapper`;
        },

        setValue(value){

            Vue.set(this.attributes, 'value', value);
            Vue.set(this.model, this.target, value);

            store.stateChanged();

            if (this.attributes['reload']) {
                store.reloadPreview()
            }
        }
    }
}