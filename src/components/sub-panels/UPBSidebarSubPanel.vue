<template>
    <div id="sidebar-sub-panel" :class="subPanelClass">
        <!-- Did not use keep-alive because we always load data via ajax -->

        <component :model="model" v-if="panel" :is="subPanelComponent"></component>
    </div>
</template>
<style src="../../scss/upb-sidebar-sub-panel.scss" lang="scss"></style>
<script src="./UPBSidebarSubPanel.js"></script>