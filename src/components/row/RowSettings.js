import Vue from 'vue';
import store from '../../store'
import {sprintf} from 'sprintf-js';
import extend from 'extend';

import fieldsComponent from '../attributes-input/fields';

// Row
// import Row from '../row/Row.vue'
// Vue.component('row', Row);

//import extend from 'extend';

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

// loop and register component
// Dynamically Import
Object.keys(fieldsComponent).map((key) => {

    if (typeof fieldsComponent[key] == 'object') {
        Vue.component(key, fieldsComponent[key])
    }
});

export default {
    name  : 'row-settings',
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
                name   : `section-contents`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    type      : 'contents'
                }
            });
        },

        getItem(){

            let sectionId = this.$route.params['sectionId'];
            let rowId     = this.$route.params['rowId'];

            console.log(this.model.contents[sectionId]['contents'][rowId]);

            return this.model.contents[sectionId]['contents'][rowId];

        },

        toggleHelp(){
            this.showSearch = false;
            this.showHelp   = !this.showHelp;
        }
    },

    components : fieldsComponent

}