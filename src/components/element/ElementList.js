import Vue, { util } from 'vue';
import store from '../../store'
import {sprintf} from 'sprintf-js'

// Section Contents
//import SectionContentsPanel from '../section/SectionContentsPanel.vue'
//Vue.component('section-contents-panel', SectionContentsPanel);

// Section Settings
//import SectionSettingsPanel from '../section/SectionSettingsPanel.vue'
//Vue.component('section-settings-panel', SectionSettingsPanel);

export default {
    name    : 'element-list',
    props   : ['index', 'model'],
    data(){
        return {
            l10n : store.l10n,
            item : []
        }
    },
    methods : {

        title(){
            return this.model.attributes['title'] ? this.model.attributes.title : this.model._upb_options.element.name;
        },

        toolsList(){

            return this.model._upb_options.tools.list.filter((tool)=> {

                if (tool.id == 'contents' && (_.isString(this.model.contents) || _.isBoolean(this.model.contents) )) {
                    // Text content do not need to show on panel it will shown on settings
                    return false;
                }

                if (tool.id == 'settings' && _.isEmpty(this.model.attributes)) {

                    // No Attributes
                    return false;
                }

                return true;
            })

        },

        activeFocus(){
            this.model._upb_options.focus = true;
        },

        removeFocus(){
            this.model._upb_options.focus = false;
        },

        contentsAction(id, tool){

            // console.log(this.$route.params);

            //this.$router.push('/sections/0/contents')

            this.removeFocus();


            this.$router.push({
                name   : `element-${id}`,
                params : {
                    //tab       : 'sections',
                    elementId : this.index,
                    sectionId : this.$route.params.sectionId,
                    rowId     : this.$route.params.rowId,
                    columnId  : this.$route.params.columnId,
                    type      : id
                }
            });
        },

        settingsAction(id, tool){

            this.removeFocus();

            this.$router.push({
                name   : `element-${id}`,
                params : {
                    //tab       : 'sections',
                    sectionId : this.$route.params.sectionId,
                    rowId     : this.$route.params.rowId,
                    columnId  : this.$route.params.columnId,
                    elementId : this.index,
                    type      : id
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

        clickActions(id, tool){
            if (this[`${id}Action`]) {
                this[`${id}Action`](id, tool)
            }
            else {
                util.warn(`You need to implement "${id}Action" method.`, this);
            }
        },

        toolsClass(id, tool){
            return tool['class'] ? `${id} ${tool['class']}` : `${id}`;
        },

        itemClass(){
            return [this.model.attributes.enable ? 'item-enabled' : 'item-disabled', this.model._upb_options.focus ? 'item-focused' : 'item-unfocused'].join(' ');
        },
    }
}