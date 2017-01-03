import Vue, { util } from 'vue';

import store from '../../store'

import Sortable from '../../plugins/vue-sortable'
import extend from 'extend';
import {sprintf} from 'sprintf-js';

import ElementList from '../element/ElementList.vue';

Vue.component('element-list', ElementList);

Vue.use(Sortable);

// Element List
//Vue.component('element-list', ElementList);

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

export default {
    name  : 'element-contents',
    props : ['index', 'model'],

    data(){
        return {
            l10n       : store.l10n,
            breadcrumb : store.breadcrumb,

            showHelp    : false,
            showSearch  : false,
            searchQuery : '',
            sortable    : {
                handle      : '> .tools > .handle',
                placeholder : "upb-sort-placeholder",
                axis        : 'y'
            },
            item        : {}
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
                return sprintf(this.item._upb_options.meta.contents.title, this.item.attributes.title)
            }
            else {
                return false;
            }
        },

        panelMetaHelp(){

            if (this.item['_upb_options']) {
                return this.item._upb_options.meta.contents.help
            }
            else {
                return false;
            }

        },

        panelMetaTools(){

            if (this.item['_upb_options']) {
                return this.item._upb_options.tools.contents;
            }
            else {
                return false;
            }

        },

        contents(){

            if (!this.item['contents']) {
                return {};
            }

            let query = this.searchQuery.toLowerCase().trim();

            if (query) {
                return this.item.contents.filter((data) => {
                    let title = data.attributes['title'] ? data.attributes.title : data._upb_options.element.name;
                    return new RegExp(query, 'gui').test(title.toLowerCase().trim())
                })
            }
            else {
                return this.item.contents;
            }
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

        addNew(content, event = false){

            let data              = extend(true, {}, content);
            data.attributes.title = sprintf(data.attributes.title, (this.item.contents.length + 1));

            this.item.contents.push(data);
            store.stateChanged();
        },

        deleteItem(index){
            this.item.contents.splice(index, 1);
            store.stateChanged();
        },

        cloneItem(index, item){
            let cloned = extend(true, {}, item);
            if (cloned.attributes['title']) {
                cloned.attributes.title = sprintf(this.l10n.clone, cloned.attributes.title);
            }
            this.item.contents.splice(index + 1, 0, cloned);
            store.stateChanged();
        },

        onStart(e){
            this.searchQuery = ''
        },

        onUpdate(e, values){


            //###
            //this.contents.splice(values.newIndex, 0, this.contents.splice(values.oldIndex, 1).pop());
            store.stateChanged();

            let list = extend(true, [], this.item.contents);

            list.splice(values.newIndex, 0, list.splice(values.oldIndex, 1).pop());

            Vue.delete(this.item, 'contents');

            this.$nextTick(() => {
                Vue.set(this.item, 'contents', extend(true, [], list));
            });
        },

        // Alias of showContentPanel
        showContentsPanel(){
            this.showContentPanel();
        },

        showContentPanel(){

            this.$router.push({
                name   : `element-contents`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    rowId     : this.$route.params.rowId,
                    columnId  : this.$route.params.columnId,
                    elementId : this.$route.params.elementId,
                    type      : 'contents'
                }
            });
        },

        showSettingsPanel(){

            this.$router.push({
                name   : `element-settings`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    rowId     : this.$route.params.rowId,
                    columnId  : this.$route.params.columnId,
                    elementId : this.$route.params.elementId,
                    type      : 'settings'
                }
            });
        },

        getItem(){

            let sectionId = this.$route.params['sectionId'];
            let rowId     = this.$route.params['rowId'];
            let columnId  = this.$route.params['columnId'];
            let elementId = this.$route.params['elementId'];
            return this.model.contents[sectionId].contents[rowId].contents[columnId].contents[elementId];

        },

        toggleHelp(){
            this.showSearch = false;
            this.showHelp   = !this.showHelp;
        },

        toggleFilter(){
            this.showHelp   = false;
            this.showSearch = !this.showSearch;

            this.$nextTick(() => {
                if (this.showSearch) {
                    this.$el.querySelector('input[type="search"]').focus()
                }
            });
        },
    }
}