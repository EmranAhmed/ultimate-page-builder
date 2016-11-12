<template>
    <div id="upb-sidebar">
        <div id="progress-bar"></div>
        <upb-sidebar-header :model="store.tabs"></upb-sidebar-header>
        <upb-sidebar-content :model="store.tabs"></upb-sidebar-content>
        <upb-sidebar-footer :model="store.tabs"></upb-sidebar-footer>
    </div>
</template>
<style src="./scss/upb-sidebar.scss" lang="sass"></style>
<script>
    import Vue from 'vue';

    import UPBSidebarHeader from './components/UPBSidebarHeader.vue';
    import UPBSidebarContent from './components/UPBSidebarContent.vue';
    import UPBSidebarFooter from './components/UPBSidebarFooter.vue';

    Vue.component('upb-sidebar-header', UPBSidebarHeader);
    Vue.component('upb-sidebar-content', UPBSidebarContent);
    Vue.component('upb-sidebar-footer', UPBSidebarFooter);

    export default {
        name : 'upb-sidebar',
        data(){
            return this.$root.$data
        }
    }
</script>