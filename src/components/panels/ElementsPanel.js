import Vue, { util } from 'vue';
import store from '../../store'

import extend from 'extend';
import {sprintf} from 'sprintf-js';

import fieldsComponent from '../settings-input/fields';

import UPBBreadcrumb from '../extra/UPBBreadcrumb.vue';
Vue.component('upb-breadcrumb', UPBBreadcrumb);

// loop and register component
// Dynamically Import
/*
 Object.keys(fieldsComponent).map((key) => {

 if (typeof fieldsComponent[key] == 'object') {
 Vue.component(key, fieldsComponent[key])
 }
 });
 */

import ElementsList from './ElementsList.vue';
Vue.component('upb-elements-list', ElementsList);

export default {
    name  : 'elements-panel',
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

    mounted(){
        this.loadContents();
    },

    methods : {

        panelClass(){
            return [`upb-${this.model.id}-panel`, `upb-panel-wrapper`].join(' ');
        },

        loadContents(){

            if (this.model.contents.length <= 0) {
                this.$progressbar.show();
                store.getPanelContents('_get_upb_element_list', (contents) => {

                    console.log(contents);

                    let data = contents.filter(function (content) {

                        if (content._upb_options['core'] && content._upb_options.core) {

                        }
                        else {
                            return content;
                        }

                    });

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

    // components : fieldsComponent
}