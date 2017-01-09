import store from '../../store'

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
        return {
            l10n : store.l10n
        }
    },

    computed : {

        is_sidebar_expanded(){
            return this.$root.$data.store.sidebarExpanded
        },

        is_enabled(){

            if (!_.isUndefined(this.model.attributes['enable'])) {
                return this.model.attributes.enable;
            }
            else {
                return true;
            }

        },

        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        },
        has_contents(){
            return _.isArray(this.model.contents);
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
            this.$nextTick(_=> {
                let path = `/sections/%/contents`.replace('%', this.model._upb_options._keyIndex);
                this.$router.replace(path);
            })
        },

        openSettingsPanel(){
            this.$router.replace(`/sections`);
            this.$nextTick(_=> {
                let path = `/sections/%/settings`.replace('%', this.model._upb_options._keyIndex);
                this.$router.replace(path);
            })
        }
    }
}