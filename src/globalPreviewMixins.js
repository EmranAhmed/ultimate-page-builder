export default{
    props : {
        index : {
            type : Number
        },

        model : {
            type : Object
        }
    },

    computed : {
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
    }
}