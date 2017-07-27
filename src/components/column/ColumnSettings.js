import store from "../../store";
import { sprintf } from "sprintf-js";
import fieldsComponent from "../settings-input/fields";

export default {
    name  : 'column-settings',
    props : ['index', 'model'],

    data(){
        return {
            l10n       : store.l10n,
            showHelp   : false,
            showSearch : false,
            item       : {}
        }
    },

    created(){

        if (this.model.contents.length < 1) {
            this.$router.replace(`/sections`);
        }
        else {
            this.item = this.getItem();
        }
    },

    computed : {

        panelTitle(){
            if (this.item['_upb_options']) {
                return sprintf(this.item._upb_options.meta.settings.title, this.item.attributes.title)
            }
            else {
                return false;
            }
        },

        panelMetaHelp(){

            if (this.item['_upb_options']) {
                return this.item._upb_options.meta.settings.help
            }
            else {
                return false;
            }
        },

        panelMetaSearch(){
            return false;
        },

        panelMetaTools(){

            if (this.item['_upb_options']) {
                return this.item._upb_options.tools.settings;
            }
            else {
                return false;
            }
        },

        contents(){
            return this.item['_upb_settings'] ? this.item : {}
        }
    },

    methods : {

        toolsAction(tool, event = false){

            let data = tool.data ? tool.data : false;

            if (!this[tool.action]) {
                util.warn(`You need to implement '${tool.action}' method.`, this);
            }
            else {
                this[tool.action](data, event);
            }
        },

        isSubPanel(){
            return (this.$route.meta['subPanel']) ? this.$route.meta.subPanel : false;
        },

        panelClass(){
            return [`upb-${this.model.id}-panel`, `upb-panel-wrapper`].join(' ');
        },

        back(){
            this.$router.go(-1);
        },

        showContentPanel(){

            this.$router.push({
                name   : `column-contents`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    rowId     : this.$route.params.rowId,
                    columnId  : this.$route.params.columnId,
                    type      : 'contents'
                }
            });
        },

        getItem(){

            let sectionId = this.$route.params['sectionId'];
            let rowId     = this.$route.params['rowId'];
            let columnId  = this.$route.params['columnId'];
            return this.model.contents[sectionId].contents[rowId].contents[columnId];
        },

        toggleHelp(){
            this.showSearch = false;
            this.showHelp   = !this.showHelp;
        }
    },

    components : fieldsComponent
}