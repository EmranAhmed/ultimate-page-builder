import store from '../../store'

export default{

    props : ['index', 'target', 'model', 'attributes', 'item'], // model[target]
    data(){
        return {
            input : this.model[this.target]
        }
    },

    watch : {
        input(value){
            this.setValue(value);
        }
    },

    created(){
        this.$watch(`modelxxx`, (value) => {

            this.attributes.value = value;

            store.stateChanged();

            if (this.attributes['reload']) {
                store.reloadPreview()
            }
        });

    },
    methods : {
        typeClass(){
            return `${this.attributes.type}-field-wrapper form-field-wrapper`;
        },

        setValue(value){

            this.attributes.value   = value;
            this.model[this.target] = value;

            store.stateChanged();

            if (this.attributes['reload']) {
                store.reloadPreview()
            }

        }
    }
}