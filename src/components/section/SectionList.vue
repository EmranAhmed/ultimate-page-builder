<template>
    <li :class="itemClass()">


        <ul class="tools">
            <li v-for="(tool, id) in model.tools" @click="clickActions(id, tool)" v-if="enabled(id)" :title="tool.title" :class="toolsClass(id, tool)">
                <i :class="tool.icon"></i>
            </li>
        </ul>

        <div v-text="model.title"></div>


    </li>
</template>
<style lang="sass">

</style>
<script>

    import Vue from 'vue';
    import store from '../../store'

    import {sprintf} from 'sprintf-js'

    // Section Contents
    import SectionContents from '../section/SectionPanel.vue'
    Vue.component('section-panel', SectionContents);

    // Section Settings
    import SectionSettingsPanel from '../section/SectionSettingsPanel.vue'
    Vue.component('section-settings-panel', SectionSettingsPanel);

    export default {
        name     : 'section-list',
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

                this.$emit('showContentPanel')

                console.log('OPEN CONTENTS PANEL')
                //this.breadcrumb.push(`${this.model.id}`)
            },

            settingsAction(id, tool){
                this.$emit('showSettingsPanel')

                console.log('OPEN SETTINGS PANEL')
            },

            deleteAction(id, tool){
                if (confirm(sprintf(this.l10n.delete, this.model.title))) {
                    this.$emit('deleteSection')
                }
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
                return `${id}-panel`;
            },
            getSettingPanel(id){
                return `${id}-settings-panel`;
            }
        }
    }
</script>
