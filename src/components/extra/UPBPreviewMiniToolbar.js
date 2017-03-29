import store from '../../store'
import {sprintf} from 'sprintf-js'

export default {
    name     : 'upb-preview-mini-toolbar',
    props    : {
        parent     : {
            type     : Object,
            required : true
        },
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
        },
        showDelete : {
            type    : Boolean,
            default : true
        }
    },
    data(){
        return {
            l10n : store.l10n
        }
    },
    computed : {

        is_movable(){
            return !this.model._upb_options.core && !this.model._upb_options.element.child;
        },

        is_sidebar_expanded(){

            if (this.$root.$data.store.sidebarExpanded) {
                Vue.set(this.model._upb_options, 'hasMiniToolbar', true);
            }
            else {
                Vue.set(this.model._upb_options, 'hasMiniToolbar', false);
            }

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
            this.$nextTick(()=> {
                let path = `/sections/%/contents`.replace('%', this.model._upb_options._keyIndex);
                this.$router.replace(path);
            })
        },

        removeElement(){
            if (this.showDelete) {
                if (confirm(sprintf(this.l10n.delete, this.model._upb_options.element.name))) {

                    let index = this.model._upb_options._keyIndex.split('/').pop();
                    this.parent.contents.splice(index, 1);

                    store.stateChanged();

                    this.$router.replace(`/elements`);
                }
            }
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