<!--
<template src="./template.html"></template>
<style src="./style.css"></style>
<script src="./script.js"></script>
-->
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
<style src="./scss/upb-sidebar.scss" lang="scss"></style>
<script src="./UPBSidebar.js"></script>