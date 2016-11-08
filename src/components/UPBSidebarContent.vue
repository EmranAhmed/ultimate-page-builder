<template>
    <div id="upb-sidebar-contents">
        <component v-for="item in model" v-if="item.active" :model="item" :is="getPanel(item.id)"></component>
    </div>
</template>
<style src="../scss/upb-sidebar-content.scss" lang="sass"></style>
<script>

    import Vue from 'vue';
    import store from '../store'

    // Sections Panel
    import SectionsPanel from './panel/SectionsPanel.vue'
    Vue.component('sections-panel', SectionsPanel);

    // Elements Panel

    // Settings Panel

    // Logical Panel

    export default {
        name    : 'upb-sidebar-contents',
        props   : ['index', 'model'],
        methods : {
            getPanel(id){
                return `${id}-panel`;
            }
        }
    }
</script>
