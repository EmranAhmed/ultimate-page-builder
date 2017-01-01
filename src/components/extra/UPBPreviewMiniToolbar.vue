<template>
    <div :class="className()" v-if="sidebarExpanded">
        <ul v-if="!onlyBorder">
            <li><span v-text="model._upb_options.element.name"></span></li>
            <li v-if="has_contents && contents" @click.prevent="openContentsPanel()"><i class="mdi mdi-book-open"></i></li>
            <li v-if="has_settings && settings" @click.prevent="openSettingsPanel()"><i class="mdi mdi-settings"></i></li>
        </ul>
    </div>
</template>
<script src="./UPBPreviewMiniToolbar.js"></script>
