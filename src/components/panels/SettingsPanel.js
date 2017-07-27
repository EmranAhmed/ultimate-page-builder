import { util } from "vue";
import { sprintf } from "sprintf-js";
import fieldsComponent from "../settings-input/fields";

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