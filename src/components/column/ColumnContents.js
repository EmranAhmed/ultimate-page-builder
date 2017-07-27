import Vue, { util } from "vue";

import store from "../../store";
import extend from "extend";
import { sprintf } from "sprintf-js";

export default {
    name  : 'column-contents',
    props : ['index', 'model'],

    data(){
        return {

            l10n        : store.l10n,
            showHelp    : false,
            showSearch  : false,
            sortable    : {
                handle      : '> .tools > .handle',
                placeholder : "upb-sort-placeholder",
                axis        : 'y'
            },
            searchQuery : '',
            item        : {},
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

        panelMetaSearch(){

            if (this.item['_upb_options']) {
                return this.item._upb_options.meta.contents.search
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

        isSubPanel(){
            return (this.$route.meta['subPanel']) ? this.$route.meta.subPanel : false;
        },

        back(){
            this.$router.go(-1);
        },

        panelClass(){
            return [`upb-${this.item.tag}-panel`, `upb-panel-wrapper`].join(' ');
        },

        getItem(){
            let sectionId = this.$route.params['sectionId'];
            let rowId     = this.$route.params['rowId'];
            let columnId  = this.$route.params['columnId'];
            return this.model.contents[sectionId].contents[rowId].contents[columnId];
        },

        showSettingsPanel(){
            this.$router.push({
                name   : `column-settings`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    rowId     : this.$route.params.rowId,
                    columnId  : this.$route.params.columnId,
                    type      : 'settings'
                }
            });
        },

        showElementsPanel(){
            this.$router.push({
                name   : `elements`,
                params : {
                    tab : `elements`,
                }
            });
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

        onUpdate(e, values){


            //###
            //this.contents.splice(values.newIndex, 0, this.contents.splice(values.oldIndex, 1).pop());
            store.stateChanged();

            //### If you Need to modify this.model.contents then you should use this code :)
            let list = extend(true, [], this.item.contents);

            list.splice(values.newIndex, 0, list.splice(values.oldIndex, 1).pop());

            Vue.delete(this.item, 'contents');

            this.$nextTick(() => {
                Vue.set(this.item, 'contents', extend(true, [], list));
            });

            // store.stateChanged();
        },

        onStart(e){
            this.searchQuery = '';
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

        toolsAction(tool, event = false){
            let data = tool.data ? tool.data : false;

            if (!this[tool.action]) {
                util.warn(`You need to implement '${tool.action}' method.`, this);
            }
            else {
                this[tool.action](data, event);
            }
        }
    },

    components : {
        'element-list' : () => import(/* webpackChunkName: "element-list" */ '../element/ElementList.vue')
    }
}
