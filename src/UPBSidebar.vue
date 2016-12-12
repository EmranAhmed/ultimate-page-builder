<!--<template src="./template.html"></template>
<style src="./style.css"></style>
<script src="./script.js"></script>-->
<template>
    <div id="upb-sidebar">
        <div id="sidebar-main-panel">
            <div id="progress-bar"></div>
            <component :model="store.tabs" is="upb-sidebar-header"></component>
            <component :model="store.tabs" is="upb-sidebar-content"></component>
            <component :model="store.tabs" is="upb-sidebar-footer"></component>
        </div>

        <component :model="store.tabs" :panel="store.subpanel" is="upb-sidebar-sub-panel"></component>
    </div>
</template>
<style src="./scss/upb-sidebar.scss" lang="sass"></style>
<script>
    import Vue from 'vue';
    import store from './store'

    import UPBSidebarHeader from './components/sidebar/UPBSidebarHeader.vue';
    import UPBSidebarContent from './components/sidebar/UPBSidebarContent.vue';
    import UPBSidebarFooter from './components/sidebar/UPBSidebarFooter.vue';

    import UPBSidebarSubPanel from './components/sub-panels/UPBSidebarSubPanel.vue';

    Vue.component('upb-sidebar-header', UPBSidebarHeader);
    Vue.component('upb-sidebar-content', UPBSidebarContent);
    Vue.component('upb-sidebar-footer', UPBSidebarFooter);

    Vue.component('upb-sidebar-sub-panel', UPBSidebarSubPanel);

    export default {
        name : 'upb-sidebar',
        data(){
            return this.$root.$data
        }
    }
</script>