<template>
    <div id="sidebar-sub-panel" :class="subPanelClass">
        <component :model="model" v-if="panel" :is="subPanelComponent"></component>
    </div>
</template>
<style src="../../scss/upb-sidebar-sub-panel.scss" lang="scss"></style>
<script src="./UPBSidebarSubPanel.js"></script>