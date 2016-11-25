import store from '../../store'

export default {
    name  : 'upb-sidebar-header-item',
    props : ['index', 'model'],

    methods : {

        url(){
            return `/${this.model.id}`;
        },

        isDirty(){
            return store.isDirty();
        }
    }
}