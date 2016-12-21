import store from '../../store'

export default{

    props : ['index', 'target', 'model', 'attributes', 'item'], // model[target]
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

    watch : {
        input(value){
            this.setValue(value);
        }
    },
    methods : {

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