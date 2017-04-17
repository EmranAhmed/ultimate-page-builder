import Vue, { util } from 'vue';
import store from '../../store'

import Draggable from '../../plugins/vue-draggable'
Vue.use(Draggable);

// import UIDraggable from '../../plugins/vue-ui-draggable'
// Vue.use(UIDraggable);

import {sprintf} from 'sprintf-js'

export default {

    name : 'upb-elements-list',

    props : ['index', 'model'],

    data(){
        return {
            l10n : store.l10n
        }
    },

    computed : {
        elementTagClass(){
            return [this.model._upb_options.element.tag.toLowerCase(), 'element-tag-ribbon']
        }
    },

    methods : {

        activeFocus(){
            this.model._upb_options.focus = true;
        },
        removeFocus(){
            this.model._upb_options.focus = false;
        },

        contentsAction(id, tool){

            this.$emit('showContentsPanel')

            // console.log('OPEN CONTENTS PANEL')
            //this.breadcrumb.push(`${this.model.id}`)
        },

        settingsAction(id, tool){
            // this.$emit('showSettingsPanel')

            // console.log('OPEN SETTINGS PANEL')

            //this.$route.params
            this.$router.push({
                name   : `row-${id}`,
                params : {
                    //tab       : 'sections',
                    rowId : this.index,
                    //sectionId : this.$route.params
                    type  : id
                }
            });

        },

        deleteAction(id, tool){
            if (confirm(sprintf(this.l10n.delete, this.model.attributes.title))) {
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

        clickActions(id, tool){

            console.log(`${id}Action`);

            if (this[`${id}Action`]) {
                this[`${id}Action`](id, tool)
            }
            else {
                util.warn(`You need to implement ${id}Action method.`, this);
            }
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

        toolsClass(id, tool){
            return tool['class'] ? `${id} ${tool['class']}` : `${id}`;
        },

        itemClass(){

            return `${this.model.tag}-element upb-element element`
        },

        getContentPanel(id){
            return `${id}-contents-panel`;
        },

        getSettingPanel(id){
            return `${id}-settings-panel`;
        }
    }
}