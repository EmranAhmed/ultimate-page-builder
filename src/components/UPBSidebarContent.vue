<template>
    <div id="upb-sidebar-contents">
        <component v-for="item in model" v-if="item.active" :model="item" :is="getPane(item.id)"></component>
    </div>
</template>
<style src="../scss/upb-sidebar-content.scss" lang="sass"></style>
<script>

    import Vue from 'vue';

    // import store from '../store'

    // Sections Panel
    import SectionsPanel from './panel/SectionsPanel.vue'
    Vue.component('sections-panel', SectionsPanel);

    // Sections Pane
    //import SectionsPane from './pane/SectionsPane.vue'
    //Vue.component('sections-pane', SectionsPane);

    // Elements Pane

    // Settings Pane

    // Logical Pane

    export default {
        name    : 'upb-sidebar-contents',
        props   : ['index', 'model'],
        methods : {
            getPane(id){

                // console.log(`${id}-pane`)

                return `${id}-panel`;
            }
        }
    }
</script>
