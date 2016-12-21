import Vue, { util } from 'vue';
import store from '../../store'

import extend from 'extend';
import {sprintf} from 'sprintf-js';

import fieldsComponent from '../settings-input/fields';

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
    name  : 'settings-panel',
    props : ['index', 'model'],

    data(){
        return {
            showHelp   : false,
            showSearch : false
        }
    },

    computed : {
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
    },

    components : fieldsComponent
}