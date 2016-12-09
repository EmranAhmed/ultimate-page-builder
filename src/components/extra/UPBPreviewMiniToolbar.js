export default {
    name  : 'upb-preview-mini-toolbar',
    props : {
        model      : {
            type : Object
        },
        contents   : {
            type    : Boolean,
            default : true
        },
        settings   : {
            type    : Boolean,
            default : true
        },
        onlyBorder : {
            type    : Boolean,
            default : false
        }
    },
    data(){
        return {}
    },

    computed : {
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        },
        has_contents(){
            return Array.isArray(this.model.contents);
        },
        has_settings(){
            return typeof this.model.attributes === 'object';
        },

        is_focused(){
            return this.model._upb_options.focus;
        }
    },
    methods  : {

        className(){
            return [`upb-preview-mini-toolbar`, this.is_focused ? 'highlight' : ''].join(' ')
        },

        openContentsPanel(){
            this.$router.replace(`/sections`);

            this.$nextTick(()=> {
                let path = `/sections/%/contents`.replace('%', this.model._upb_options._keyIndex);
                this.$router.replace(path);
            })
        },

        openSettingsPanel(){

            this.$router.replace(`/sections`);

            this.$nextTick(()=> {
                let path = `/sections/%/settings`.replace('%', this.model._upb_options._keyIndex);
                this.$router.replace(path);
            })
        }
    }

}