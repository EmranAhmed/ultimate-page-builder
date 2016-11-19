import Vue, { util } from 'vue';

import store from '../../store'

import Sortable from '../../plugins/vue-sortable'
import extend from 'extend';
import {sprintf} from 'sprintf-js';
import RowList from '../row/RowList.vue';
import RowContents from '../row/RowContents.vue';

Vue.use(Sortable);

// Row List
Vue.component('row-list', RowList);
Vue.component('row-contents', RowContents);

export default {
    name  : 'section-contents-panel',
    props : ['index', 'model'],

    data(){
        return {
            showChild      : false,
            childId        : null,
            childComponent : '',

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
        }
    },

    computed : {

        panelClass(){
            //return [`upb-${this.model.id}-panel`, this.currentPanel ? 'current' : ''].join(' ');
            return [`upb-${this.model.tag}-panel`, `upb-panel-wrapper`].join(' ');
        },

        contents(){

            let query = this.searchQuery.toLowerCase().trim();

            if (query) {
                return this.model.contents.filter((data) => new RegExp(query, 'gui').test(data.attributes.title.toLowerCase().trim()))
            }
            else {
                return this.model.contents;
            }
        }
    },

    created(){
        this.loadContents()
    },

    methods : {

        isCurrentRow(index){
            return this.childId == index;
        },

        loadContents(){
            if (this.model.contents.length > 0) {
                this.$progressbar.show();
                store.upbElementOptions(this.model.contents, (data) => {
                    this.$nextTick(function () {
                        Vue.set(this.model, 'contents', extend(true, [], data));
                        this.afterContentLoaded();
                    });

                    this.$progressbar.hide();
                }, (data) => {
                    console.log(data);
                    this.$progressbar.hide();
                });
            }
        },

        afterContentLoaded(){
            if (this.model.contents.length > 0) {
                this.childId = 0;
                this.openContentsPanel(this.childId);
            }
        },

        afterSort(values){
            this.childId   = values.newIndex;
            this.showChild = true;
        },

        showSettingsPanel(){
            this.$emit('showSettingsPanel')
        },

        back(){
            this.$emit('onBack')
        },

        backed(){
            this.breadcrumb.pop();
            this.showChild      = false;
            this.childId        = null;
            this.childComponent = '';
        },

        clearPanel(){
            this.breadcrumb.pop();
            this.childComponent = '';
            //this.showChild      = false;
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

        singleModel(){
            return this.model.contents[this.childId];
        },

        listPanel(id){
            return `${id}-list`
        },

        deleteItem(index){
            this.model.contents.splice(index, 1);
            store.stateChanged();
        },

        cloneItem(index, item){
            let cloned              = extend(true, {}, item);
            cloned.attributes.title = `Clone of ${cloned.attributes.title}`
            this.model.contents.splice(index + 1, 0, cloned);
            store.stateChanged();
        },

        onUpdate(e, values){


            //###
            //this.contents.splice(values.newIndex, 0, this.contents.splice(values.oldIndex, 1).pop());
            store.stateChanged();

            //### If you Need to modify this.model.contents then you should use this code :)
            let list = extend(true, [], this.model.contents);

            list.splice(values.newIndex, 0, list.splice(values.oldIndex, 1).pop());

            Vue.delete(this.model, 'contents');

            this.$nextTick(() => {
                Vue.set(this.model, 'contents', extend(true, [], list));
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

        callToolsAction(event, action, tool){

            let data = tool.data ? tool.data : false;

            if (!this[action]) {
                util.warn(`You need to implement ${action} method.`, this);
            }
            else {
                this[action](event, data);
            }
        },

        addNew(e, data){
            let section = extend(true, {}, data);

            section.attributes.title = sprintf(section.attributes.title, (this.model.contents.length + 1));

            this.model.contents.push(section);
            store.stateChanged();
        }
    }
}
