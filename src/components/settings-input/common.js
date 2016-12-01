import store from '../../store'

export default{
    created(){
        this.$watch(`model.metaValue`, (value) => {
            this.attrs.value     = value;
            //this.model.metaValue = value;

            store.stateChanged();

            if (this.attrs['reload']) {
                store.reloadPreview()
            }
        });
    },
    methods : {
        typeClass(){
            return `${this.attrs.type}-field-wrapper form-field-wrapper`;
        }
    }
}