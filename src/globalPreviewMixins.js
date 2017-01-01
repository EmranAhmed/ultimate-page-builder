import store from './store'

export default{
    props : {
        index : {
            type : Number
        },

        model : {
            type : Object
        }
    },

    data(){
        return {
            l10n : store.l10n
        }
    },

    computed : {
        hasContents(){
            if (!_.isUndefined(this.model['contents'])) {
                return this.model.contents.length > 0;
            }
        },
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
    },

    methods : {
        openElementsPanel(){
            this.$router.replace(`/elements`);
        }
    }
}