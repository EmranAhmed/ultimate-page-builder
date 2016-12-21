<template>
    <div id="upb-sidebar-header">
        <ul>
            <li class="btn-close"><a :href="l10n.closeUrl" :title="l10n.close"><i class="mdi mdi-window-close"></i></a></li>
            <ul class="tab-wrapper">
                <component v-for="item in model" :model="item" is="upb-sidebar-header-item"></component>
            </ul>
            <li :class="[{ active: isDirty() }, 'btn-save']"><a @click.prevent="save()" href="#" :title="l10n.save"><i class="mdi mdi-content-save-all"></i></a></li>
        </ul>
    </div>
</template>
<style src="../../scss/upb-sidebar-header.scss" lang="sass"></style>
<script src="./UPBSidebarHeader.js"></script>
