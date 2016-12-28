import store from '../../store'

export default{

    props : ['index', 'target', 'model', 'attributes', 'item', 'items', 'keyindexname', 'keyvaluename'], // model[target]
    data(){
        return {
            input : this.model[this.target]
        }
    },

    computed : {
        multiple(){
            return (!_.isUndefined(this.attributes['multiple']) && this.attributes.multiple) ? true : false;
        }
    },

    watch   : {
        input(value){
            this.setValue(value);
        }
    },
    methods : {

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

            let find                = {};
            find[this.keyindexname] = key;

            //console.log(this.model, key)

            this.items.filter((item, index)=> {

                if (item[this.keyindexname] == key) {

                    //console.log(index);

                    // console.log(this.attributes)
                    //console.log(item, this.keyvaluename)

                    // Settings Panel
                    if (!_.isUndefined(item['_upb_field_attrs'])) {
                        Vue.set(this.items[index]._upb_field_attrs, 'value', value);
                    }

                    // Element Setting
                    if (!_.isUndefined(this.model[key])) {
                        Vue.set(this.model, key, value);
                    }

                    Vue.set(this.items[index], this.keyvaluename, value);

                    console.log(this.model, this.target);

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

            //this.attributes.value   = value;
            //this.model[this.target] = value;

            store.stateChanged();

            if (this.attributes['reload']) {
                store.reloadPreview()
            }
        }
    }
}