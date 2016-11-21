import store from '../../store'

export default {
    name  : 'upb-sidebar-header-item',
    props : ['index', 'model'],

    methods : {

        activeTab(){
            this.$emit('changedActive', event.target.value);
            this.model.active = true
        },

        isDirty(){
            return store.isDirty();
        }
    }
}