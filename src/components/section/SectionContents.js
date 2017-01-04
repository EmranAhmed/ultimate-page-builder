import Vue, { util } from 'vue'

import store from '../../store'

import Sortable from '../../plugins/vue-sortable'
import extend from 'extend'
import {sprintf} from 'sprintf-js'

import RowList from '../row/RowList.vue'

import RowContents from '../row/RowContents.vue'

Vue.use(Sortable);

// Row List
Vue.component('row-list', RowList)
Vue.component('row-contents', RowContents)

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue'
Vue.component('upb-breadcrumb', UPBBreadcrumb)

export default {
    name  : 'section-contents',
    props : ['index', 'selected', 'model'],

    data(){
        return {

            defaultRowId         : 0,
            showRowColumn        : false,
            rowContentsComponent : '',

            l10n       : store.l10n,
            breadcrumb : store.breadcrumb,
            showHelp   : false,
            showSearch : false,
            sortable   : {
                handle      : '> .tools > .handle',
                placeholder : "upb-sort-placeholder",
                axis        : 'y'
            },

            searchQuery : '',
            item        : {}
        }
    },

    created(){

        if (this.model.contents.length < 1) {
            this.$router.replace('/sections');
        }
        else {
            this.item = this.getItem();

            if (this.item.contents.length > 0) {
                this.defaultRowId = 0;
                this.openRowContentsPanel(this.defaultRowId); // row column list
            }
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
                return this.item.contents.filter((data) => new RegExp(query, 'gui').test(data.attributes.title.toLowerCase().trim()))
            }
            else {
                return this.item.contents;
            }
        }
    },

    watch : {
        searchQuery(search){
            if (search.trim()) {
                this.showRowColumn = false; // searching rows
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

        isCurrentRow(index){
            return this.defaultRowId == index && this.showRowColumn;
        },

        getItem(){
            let sectionId = this.$route.params['sectionId'];
            return this.model.contents[sectionId];
        },

        afterSort(values){
            this.defaultRowId  = values.newIndex;
            this.showRowColumn = true;
        },

        showSettingsPanel(){

            this.$router.push({
                name   : `section-settings`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    type      : 'settings'
                }
            });
        },

        openRowContentsPanel(index){
            this.showRowColumn        = true;
            this.defaultRowId         = index;
            this.rowContentsComponent = 'row-contents';
        },

        saveSectionLayout(){

            this.$toast.info(this.l10n.sectionSaving);

            store.saveSectionToOption(this.item, (data) => {

                this.$toast.remove();

                if (data) {
                    this.$toast.success(this.l10n.sectionSaved);
                }
                else {
                    this.$toast.error(this.l10n.sectionNotSaved);
                }

            }, () => {
                this.$toast.remove();
                this.$toast.error(this.l10n.sectionNotSaved);
            });

            // console.log(this.item)

        },

        // Sub Panel

        listPanel(id){
            return `row-list`
        },

        deleteItem(index){
            this.item.contents.splice(index, 1);
            store.stateChanged();
        },

        cloneItem(index, item){
            let cloned              = extend(true, {}, item);
            cloned.attributes.title = sprintf(this.l10n.clone, cloned.attributes.title);
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
                this.afterSort(values);
            });

            // store.stateChanged();
        },

        onStart(e){
            this.searchQuery   = '';
            this.showRowColumn = false;
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
        },

        cleanup(model) {

            model.contents = model.contents.map((data, index) => {

                data.attributes.title = sprintf(data.attributes.title, (data.contents.length + 1));

                return data;
            });

            return model;
        },

        addNew(content, event = false){

            // Only For Column cleanup

            let data              = extend(true, {}, this.cleanup(content));
            data.attributes.title = sprintf(data.attributes.title, (this.item.contents.length + 1));

            this.item.contents.push(data);
            store.stateChanged();
        }
    }
}
