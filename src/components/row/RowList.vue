<template>
    <li :class="itemClass()">

        <ul class="tools">
            <li v-for="(tool, id) in model.tools.list" @click="clickActions(id, tool)" v-if="enabled(id)" :title="tool.title" :class="toolsClass(id, tool)">
                <i :class="tool.icon"></i>
            </li>
        </ul>

        <div v-text="model.title"></div>

    </li>
</template>
<style lang="sass">

</style>
<script>

    import Vue, { util } from 'vue';
    import store from '../../store'

    import {sprintf} from 'sprintf-js'

    // Section Contents
    // import SectionContentsPanel from '../section/SectionContentsPanel.vue'
    // Vue.component('section-contents-panel', SectionContentsPanel);

    // Section Settings
    // import SectionSettingsPanel from '../section/SectionSettingsPanel.vue'
    // Vue.component('section-settings-panel', SectionSettingsPanel);

    export default {
        name     : 'row-list',
        props    : ['index', 'model'],
        data(){
            return {
                l10n       : store.l10n,
                breadcrumb : store.breadcrumb,
            }
        },
        computed : {
            parentShowChild(){
                return this.$parent.$data.showChild;
            }
        },
        methods  : {

            contentsAction(id, tool){

                this.$emit('showContentsPanel')

                // console.log('OPEN CONTENTS PANEL')
                //this.breadcrumb.push(`${this.model.id}`)
            },

            settingsAction(id, tool){
                this.$emit('showSettingsPanel')

                // console.log('OPEN SETTINGS PANEL')
            },

            deleteAction(id, tool){
                if (confirm(sprintf(this.l10n.delete, this.model.title))) {
                    this.$emit('deleteItem')
                }
            },

            cloneAction(id, tool){
                this.$emit('cloneItem');
            },

            enableAction(id, tool){
                this.model.enable = false;
            },
            disableAction(id, tool){
                this.model.enable = true;
            },

            clickActions(id, tool){
                if (this[`${id}Action`]) {
                    this[`${id}Action`](id, tool)
                }
                else {
                    util.warn(`You need to implement ${id}Action method.`, this);
                }
            },

            enabled(id){

                if (id == 'enable') {
                    return this.model.enable;
                }

                if (id == 'disable') {
                    return !this.model.enable;
                }

                return true;
            },

            toolsClass(id, tool){
                return tool['class'] ? `${id} ${tool['class']}` : `${id}`;
            },

            itemClass(){
                return this.model.enable ? 'item-enabled' : 'item-disabled';
            },

            getContentPanel(id){
                return `${id}-contents-panel`;
            },
            getSettingPanel(id){
                return `${id}-settings-panel`;
            }
        }
    }
</script>
