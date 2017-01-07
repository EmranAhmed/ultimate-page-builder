import Vue, { util } from 'vue';
import store from '../../store'
import extend from 'extend';
import {sprintf} from 'sprintf-js';

// import fieldsComponent from '../settings-input/fields';

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

import ElementsList from './ElementsList.vue';
Vue.component('upb-elements-list', ElementsList);

export default {
    name  : 'elements-panel',
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
            return this.model.contents.filter(function (data) {

                if (data._upb_options.core) {
                    return false;
                }
                else {
                    if (data._upb_options.element.child) {
                        return false;
                    }
                }

                return true;
            })
        },

        contents(){
            let query = this.searchQuery.toLowerCase().trim();
            if (query) {
                return this.items.filter(function (data) {
                    return new RegExp(query, 'gui').test(data._upb_options.element.name.toLowerCase().trim())
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