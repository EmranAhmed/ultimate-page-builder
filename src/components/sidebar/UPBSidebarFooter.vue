<template>
    <div id="upb-sidebar-footer">
        <a :class="[{ current: sidebarExpand }, 'btn-collapse']" :title="l10n.collapse" @click.prevent="collapseSidebar()" href="#"><i class="mdi mdi-arrow-left-drop-circle-outline"></i></a>
        <a :class="[{ current: !sidebarExpand }, 'btn-expand']" :title="l10n.expand" @click.prevent="expandSidebar()" href="#"><i class="mdi mdi-arrow-right-drop-circle"></i></a>
        <div class="previews">
            <!--
                        <a :class="{ active: skeletonPreview }" :title="l10n.skeleton" @click.prevent="toggleSkeletonPreview()" href="#"><i class="mdi mdi-group"></i></a>
            -->
            <a v-for="device in devices" :key="device.id" v-show="deviceAvailable(device.id)" :class="{ active: currentDevice(device.id) }" :title="device.title" @click.prevent="toggleResponsivePreview(device.id)" href="#"><i :class="device.icon"></i></a>
        </div>
    </div>
</template>
<style src="../../scss/upb-sidebar-footer.scss" lang="scss"></style>
<script src="./UPBSidebarFooter.js"></script>