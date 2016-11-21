<template>
    <div id="upb-sidebar-contents">
        <component v-for="item in model" v-if="item.active" :model="item" :is="getPane(item.id)"></component>
    </div>
</template>
<style src="../../scss/upb-sidebar-content.scss" lang="sass"></style>
<script src="./UPBSidebarContent.js"></script>
