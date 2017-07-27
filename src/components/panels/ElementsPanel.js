import { util } from "vue";
import { sprintf } from "sprintf-js";

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
    },

    components : {
        'upb-elements-list' : () => import(/* webpackChunkName: "upb-elements-list" */ './ElementsList.vue')
    }
}