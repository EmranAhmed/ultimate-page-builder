<template>
    <div id="sidebar-sub-panel" :class="subPanelClass">
        <component v-if="panel" :is="subPanelComponent"></component>
    </div>
</template>
<style src="../../scss/upb-sidebar-sub-panel.scss" lang="sass"></style>

<script src="./UPBSidebarSubPanel.js"></script>