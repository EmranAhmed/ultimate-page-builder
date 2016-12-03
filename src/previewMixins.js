export default{

    props : ['index', 'model'],

    computed : {
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
    },

    methods : {

        activeFocus(){
            this.model._upb_options.focus = true;
        },

        removeFocus(){
            this.model._upb_options.focus = false;
        },

        openContentsPanel(){
            this.$router.replace(`/sections`)
            // Async
            setTimeout(_ => {
                let path = `/sections/%/contents`.replace('%', this.model.attributes._keyIndex);
                this.$router.replace(path);
            }, 10)
        },

        openSettingsPanel(){

            this.$router.replace(`/sections`)
            // Async
            setTimeout(_ => {
                let path = `/sections/%/settings`.replace('%', this.model.attributes._keyIndex);
                this.$router.replace(path);
            }, 10)
        }
    }
}