import Vue, { util } from 'vue';

import store from '../../store'

import Sortable from '../../plugins/vue-sortable'
import extend from 'extend';
import {sprintf} from 'sprintf-js';

import RowList from '../row/RowList.vue';

//import RowContents from '../row/RowContents.vue';

Vue.use(Sortable);

// Row List
Vue.component('row-list', RowList);
//Vue.component('row-contents', RowContents);

export default {
    name  : 'section-contents',
    props : ['index', 'model'],

    data(){
        return {
            /*showChild      : false,
             childId        : null,
             childComponent : '',*/

            l10n        : store.l10n,
            breadcrumb  : store.breadcrumb,
            showHelp    : false,
            showSearch  : false,
            sortable    : {
                handle      : '> .tools > .handle',
                placeholder : "upb-sort-placeholder",
                axis        : 'y'
            },
            searchQuery : '',

            item : {},

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
                this.showChild = false;
            }
        }
    },

    mounted(){
        if (this.item['contents'] && this.item.contents.length > 0) {
            this.loadContents()
        }
    },

    methods : {

        back(){
            this.$router.go(-1);
        },

        panelClass(){
            return [`upb-${this.item.tag}-panel`, `upb-panel-wrapper`].join(' ');
        },

        isCurrentRow(index){
            return this.childId == index && this.showChild;
        },

        getItem(){

            let sectionId = this.$route.params['sectionId'];
            let type      = (this.$route.params['type'] == 'settings') ? '_upb_settings' : this.$route.params['type'].trim();
            return this.model[type][sectionId];

        },

        loadContents(){

            if (this.item.contents.length > 0) {

                console.log(this.item.contents)

                this.$progressbar.show();
                store.upbElementOptions(this.item.contents, (data) => {

                    this.$nextTick(() => {
                        Vue.set(this.item, 'contents', extend(true, [], this.boolAttributes(data)));
                        this.afterContentLoaded();
                    });

                    this.$progressbar.hide();
                }, (data) => {
                    console.log(data);
                    this.$progressbar.hide();
                });
            }
        },

        boolAttributes(data){

            return data.map(function (content) {

                if (content['attributes']) {
                    Object.keys(content.attributes).map(function (key) {

                        if (content.attributes[key] == 'true') {
                            content.attributes[key] = true;
                        }

                        if (content.attributes[key] == 'false') {
                            content.attributes[key] = false;
                        }
                    })
                }
                
                return content;

            });
        },

        afterContentLoaded(){
            if (this.item.contents.length > 0) {
                //    this.childId = 0;
                //    this.openContentsPanel(this.childId);
            }
        },

        afterSort(values){
            this.childId   = values.newIndex;
            this.showChild = true;
        },

        showSettingsPanel(){
            this.$emit('showSettingsPanel')
        },

        openContentsPanel(index){

            //this.clearPanel();

            this.showChild      = true;
            this.childId        = index;
            this.childComponent = 'row-contents';
            //this.breadcrumb.push(this.model.title);
        },

        openSettingsPanel(index){

            this.clearPanel();

            this.showChild      = true;
            this.childId        = index;
            this.childComponent = 'row-settings-panel';
            this.breadcrumb.push(this.model.title);
        },

        // Sub Panel

        subPanel(){
            return this.childComponent;
        },

        singleModel(){
            return this.model.contents[this.childId];
        },

        listPanel(id){
            return `${id}-list`
        },

        deleteItem(index){
            this.item.contents.splice(index, 1);
            store.stateChanged();
        },

        cloneItem(index, item){
            let cloned              = extend(true, {}, item);
            cloned.attributes.title = `Clone of ${cloned.attributes.title}`
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
            this.searchQuery = '';
            this.showChild   = false;
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
        },
    }
}
