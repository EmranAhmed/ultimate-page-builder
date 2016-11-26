
import Vue, { util } from 'vue';
import store from '../../store'

import Sortable from '../../plugins/vue-sortable'
import extend from 'extend';
import {sprintf} from 'sprintf-js';
import SectionList from '../section/SectionList.vue';

Vue.use(Sortable);

// Section List
Vue.component('section-list', SectionList);

export default {
    name  : 'settings-panel',
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
            searchQuery : ''
        }
    },

    computed : {

        panelClass(){
            //return [`upb-${this.model.id}-panel`, this.currentPanel ? 'current' : ''].join(' ');
            return [`upb-${this.model.id}-panel`, `upb-panel-wrapper`].join(' ');
        },

        currentPanel(){
            // return this.breadcrumb[this.breadcrumb.length - 1] == this.model.id;
        },

        contents(){
            let query = this.searchQuery.toLowerCase().trim();
            if (query) {
                return this.model.contents.filter(function (data) {
                    return new RegExp(query, 'gui').test(data.title.toLowerCase().trim())
                })
            }
            else {
                return this.model.contents;
            }
        }
    },

    methods : {

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

        showContentPanel(index){

            this.clearPanel();

            this.showChild      = true;
            this.childId        = index;
            this.childComponent = 'section-contents-panel';
            this.breadcrumb.push(this.model.title);
        },

        showSettingsPanel(index){

            this.clearPanel();

            this.showChild      = true;
            this.childId        = index;
            this.childComponent = 'section-settings-panel';
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
            let cloned = extend(true, {}, item);

            cloned.title = `Clone of ${cloned.title}`;

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

            this.$nextTick(function () {
                Vue.set(this.model, 'contents', extend(true, [], list));
            });

            // store.stateChanged();
        },

        onStart(e){
            this.searchQuery = ''
        },

        toggleHelp(){
            this.showSearch = false;
            this.showHelp   = !this.showHelp;
        },

        toggleFilter(){
            this.showHelp   = false;
            this.showSearch = !this.showSearch;

            this.$nextTick(function () {
                if (this.showSearch) {
                    this.$el.querySelector('input[type="search"]').focus()
                }
            });
        },

        callToolsAction(event, action, tool){

            let data = tool.data ? tool.data : false;

            if (!this[action]) {
                util.warn(`You need to implement '${action}' method.`, this);
            }
            else {
                this[action](event, data);
            }
        },

        addNew(e, data){
            let section   = extend(true, {}, data);
            section.title = sprintf(section.title, (this.model.contents.length + 1));

            this.model.contents.push(section);
            store.stateChanged();
        }
    }
}