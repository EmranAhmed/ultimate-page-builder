import Vue from 'vue';
import store from '../../store'
import {sprintf} from 'sprintf-js';
import extend from 'extend';
import Sortable from '../../plugins/vue-sortable'
Vue.use(Sortable);

// Row
// import Row from '../row/Row.vue'
// Vue.component('row', Row);

//import extend from 'extend';

export default {
    name  : 'section-settings-panel',
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

        panelTitle(){
            return sprintf(this.model._upb_options.meta.settings.title, this.model.attributes.title)
        },

        currentPanel(){
            return this.breadcrumb[this.breadcrumb.length - 1] == this.model.id;
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

        panelClass(){
            return [`upb-${this.model.id}-panel`, `upb-panel-wrapper`].join(' ');
        },

        back(){
            this.$emit('onBack')
        },

        showContentPanel(){
            this.$emit('showContentPanel')
        },

        itemPanel(id){
            return `${this.model.id}-item`
        },

        deleteSection(index){
            this.model.contents.splice(index, 1);
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

        toolsAction(tool, event = false){

            let data = tool.data ? tool.data : false;

            if (!this[tool.action]) {
                util.warn(`You need to implement '${tool.action}' method.`, this);
            }
            else {
                this[tool.action](data, event);
            }
        },

        addNewRow(e, data){
            let section = extend(true, {}, data);
            section.title += ' ' + (this.model.contents.length + 1);
            this.model.contents.push(section);
            store.stateChanged();
        }
    }
}