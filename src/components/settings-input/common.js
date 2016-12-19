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

    created(){

        // No Value but have default
        if (_.isNull(this.attributes.value) && !_.isNull(this.attributes.default)) {
            this.input = this.attributes.default
        }

        // Have Default value
        if (!_.isNull(this.attributes.value)) {
            this.input = this.attributes.value
        }
    },
    methods : {
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