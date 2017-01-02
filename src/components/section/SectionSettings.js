import Vue from 'vue';
import store from '../../store'
import {sprintf} from 'sprintf-js';
import extend from 'extend';
import fieldsComponent from '../settings-input/fields';
import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

export default {
    name  : 'section-settings',
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
            this.$router.replace('/sections');
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

            let params = this.$route.params;

            this.$router.push({
                name   : `section-contents`,
                params : {
                    //tab       : 'sections',
                    sectionId : params.sectionId,
                    type      : 'contents'
                }
            });
        },

        getItem(){
            let sectionId = this.$route.params['sectionId'];
            return this.model.contents[sectionId];
        },

        toggleHelp(){
            this.showSearch = false;
            this.showHelp   = !this.showHelp;
        }
    },

    components : fieldsComponent

}