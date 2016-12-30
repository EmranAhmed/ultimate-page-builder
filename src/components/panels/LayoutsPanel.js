import Vue, { util } from 'vue';
import store from '../../store'

import extend from 'extend';
import {sprintf} from 'sprintf-js';

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

import LayoutsList from './LayoutsList.vue';
Vue.component('upb-layouts-list', LayoutsList);

export default {
    name  : 'layouts-panel',
    props : ['index', 'model'],

    data(){
        return {
            showHelp    : false,
            showSearch  : false,
            searchQuery : ''
        }
    },

    computed : {
        items(){
            return this.model.contents
        },

        contents(){
            let query = this.searchQuery.toLowerCase().trim();
            if (query) {
                return this.items.filter(function (data) {
                    let title = new RegExp(query, 'gui').test(data.title.toLowerCase().trim());
                    let desc  = data.desc ? new RegExp(query, 'gui').test(data.desc.toLowerCase().trim()) : false;
                    return title || desc;
                })
            }
            else {
                return this.items;
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
        }
    }

    // components : fieldsComponent
}