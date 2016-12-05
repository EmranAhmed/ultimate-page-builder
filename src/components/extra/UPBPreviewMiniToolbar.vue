<template>
    <div :class="className()">
        <ul>
            <li><span v-text="model._upb_options.element.name"></span> - <span v-text="model.attributes.title"></span></li>
            <li v-if="has_contents && contents" @click.prevent="openContentsPanel()"><i class="mdi mdi-book-open"></i></li>
            <li v-if="has_settings && settings" @click.prevent="openSettingsPanel()"><i class="mdi mdi-settings"></i></li>
        </ul>
    </div>
</template>
<script src="./UPBPreviewMiniToolbar.js"></script>
