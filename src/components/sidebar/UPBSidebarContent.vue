<template>
    <div id="upb-sidebar-contents">
        <!--
        <transition :name="transitionName">
            <router-view :model="item"></router-view>
        </transition>
        -->
        <router-view :model="item"></router-view>
    </div>
</template>
<style src="../../scss/upb-sidebar-content.scss" lang="sass"></style>
<script src="./UPBSidebarContent.js"></script>

