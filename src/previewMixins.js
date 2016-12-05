export default{

    props : ['index', 'model'],

    data(){
        return {}
    },

    computed : {
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
    },

    methods : {}
}