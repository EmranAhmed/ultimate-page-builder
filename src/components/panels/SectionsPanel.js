import Vue, { util } from 'vue';
import store from '../../store'

import extend from 'extend';
import {sprintf} from 'sprintf-js';

import Sortable from '../../plugins/vue-sortable'
Vue.use(Sortable);

// Section List
import SectionList from '../section/SectionList.vue';
Vue.component('section-list', SectionList);

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

export default {
    name  : 'sections-panel',
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

            transitionName : 'slide-left'
        }
    },

    computed : {
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

    mounted(){
        this.loadContents();
    },

    watch : {
        $route (to, from) {

            this.loadContents();

            /*const toDepth       = to.path.split('/').length;
             const fromDepth     = from.path.split('/').length;
             this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';
             */
            //console.log(toDepth, fromDepth)
        }
    },

    methods : {

        loadContents(){
            // load data
            if (this.model.contents.length <= 0) {
                this.$progressbar.show();
                store.getPanelContents('_get_upb_sections_panel_contents', (data) => {

                    console.log(data);

                    this.$nextTick(function () {
                        Vue.set(this.model, 'contents', extend(true, [], data));
                    });

                    this.$progressbar.hide();
                }, (data) => {
                    console.log(data);
                    this.$progressbar.hide();
                });
            }
        },

        // Main Panel

        panelClass(){
            //return [`upb-${this.model.id}-panel`, this.currentPanel ? 'current' : ''].join(' ');
            return [`upb-${this.model.id}-panel`, `upb-panel-wrapper`].join(' ');
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

        openSubPanel(data, event){
            store.subpanel = (store.subpanel == data) ? '' : data;
        },

        toolsActiveClass(tool){
            return (_.isString(tool.data) && store.subpanel == tool.data) ? 'active' : '';
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

        addNew(content, event = false){

            let data              = extend(true, {}, content);
            data.attributes.title = sprintf(data.attributes.title, (this.model.contents.length + 1));

            this.model.contents.push(data);
            store.stateChanged();
        },

        // List Contents

        listPanel(id){
            return `${id}-list`
        },

        deleteItem(index){
            this.model.contents.splice(index, 1);
            store.stateChanged();
        },

        cloneItem(index, item){
            let cloned = extend(true, {}, item);

            cloned.attributes.title = sprintf(this.l10n.clone, cloned.attributes.title);

            this.model.contents.splice(index + 1, 0, cloned);
            store.stateChanged();
        },

        onStart(e){
            this.searchQuery = ''
        },

        onUpdate(e, values){


            //###
            //this.contents.splice(values.newIndex, 0, this.contents.splice(values.oldIndex, 1).pop());
            store.stateChanged();

            let list = extend(true, [], this.model.contents);

            list.splice(values.newIndex, 0, list.splice(values.oldIndex, 1).pop());

            Vue.delete(this.model, 'contents');

            this.$nextTick(() => {
                Vue.set(this.model, 'contents', extend(true, [], list));
            });
        }
    }
}
