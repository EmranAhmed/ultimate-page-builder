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

    export default {
        name    : 'section-item',
        props   : ['index', 'model'],
        data(){
            return {
                l10n : store.l10n
            }
        },
        methods : {

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

            getPanel(id){
                return `${id}-panel`;
            }
        }
    }
</script>
