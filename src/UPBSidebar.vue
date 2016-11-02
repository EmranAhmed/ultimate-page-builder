<template>
    <div id="upb-sidebar">
        <upb-sidebar-header :model="store.states"></upb-sidebar-header>
        <upb-sidebar-contents :model="store.states"></upb-sidebar-contents>
        <upb-sidebar-footer :model="store.states"></upb-sidebar-footer>
    </div>
</template>
<style src="./scss/upb-sidebar.scss" lang="sass"></style>
<script>
    import Vue from 'vue';

    import UPBSidebarHeader from './components/UPBSidebarHeader.vue';
    import UPBSidebarContents from './components/UPBSidebarContents.vue';
    import UPBSidebarFooter from './components/UPBSidebarFooter.vue';

    Vue.component('upb-sidebar-header', UPBSidebarHeader);
    Vue.component('upb-sidebar-contents', UPBSidebarContents);
    Vue.component('upb-sidebar-footer', UPBSidebarFooter);

    export default {
        name : 'upb-sidebar',
        data(){
            return this.$root.$data
        }
    }
</script>