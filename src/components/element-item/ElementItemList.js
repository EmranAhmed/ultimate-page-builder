import { util } from "vue";
import store from "../../store";
import { sprintf } from "sprintf-js";

export default {
    name    : 'element-item-list',
    props   : ['index', 'model'],
    data(){
        return {
            l10n : store.l10n,
            item : []
        }
    },
    created(){
        this.$watch(`model.attributes`, (value) => {
            store.stateChanged();
        }, {deep : true});
    },
    methods : {
        title(){
            return this.model.attributes['title'] ? this.model.attributes.title : this.model._upb_options.element.name;
        },

        activeFocus(){
            this.model._upb_options.focus = true;
        },

        removeFocus(){
            this.model._upb_options.focus = false;
        },

        contentsAction(id, tool){

            this.removeFocus();

            this.$router.push({
                name   : `element-item-${id}`,
                params : {
                    //tab       : 'sections',
                    elementItemId : this.index,
                    elementId     : this.$route.params.elementId,
                    sectionId     : this.$route.params.sectionId,
                    rowId         : this.$route.params.rowId,
                    columnId      : this.$route.params.columnId,
                    type          : id
                }
            });
        },

        settingsAction(id, tool){

            this.removeFocus();

            this.$router.push({
                name   : `element-item-${id}`,
                params : {
                    //tab       : 'sections',
                    sectionId     : this.$route.params.sectionId,
                    rowId         : this.$route.params.rowId,
                    columnId      : this.$route.params.columnId,
                    elementId     : this.$route.params.elementId,
                    elementItemId : this.index,
                    type          : id
                }
            });
        },

        deleteAction(id, tool){

            let title = this.model.attributes['title'] ? this.model.attributes.title : this.model._upb_options.element.name

            if (confirm(sprintf(this.l10n.delete, title))) {
                this.$emit('deleteItem')
            }
        },

        cloneAction(id, tool){
            this.$emit('cloneItem');
        },

        enableAction(id, tool){
            this.model.attributes.enable = false;
        },

        disableAction(id, tool){
            this.model.attributes.enable = true;
        },

        enabled(id){

            if (id == 'enable') {
                return this.model.attributes.enable;
            }

            if (id == 'disable') {
                return !this.model.attributes.enable;
            }

            return true;
        },

        active(id){

            if (id == 'active') {
                return this.model.attributes.active;
            }
            return true;
        },

        clickActions(id, tool){

            if (tool.action == false) {
                return '';
            }

            if (this[`${id}Action`]) {
                this[`${id}Action`](id, tool)
            }
            else {
                util.warn(`You need to implement "${id}Action" method. Or Make Action false on ${id}`, this);
            }
        },

        toolsClass(id, tool){
            return tool['class'] ? `${id} ${tool['class']}` : `${id}`;
        },

        itemClass(){

            // If not enable found default class will be true
            let isEnable        = (_.isUndefined(this.model.attributes['enable']) || this.model.attributes.enable) ? true : false;
            let isDefaultActive = (_.isUndefined(this.model.attributes['active']) || this.model.attributes.active) ? true : false;

            return [isDefaultActive ? 'item-active' : '', isEnable ? 'item-enabled' : 'item-disabled', this.model._upb_options.focus ? 'item-focused' : 'item-unfocused'].join(' ');
        }
    }
}