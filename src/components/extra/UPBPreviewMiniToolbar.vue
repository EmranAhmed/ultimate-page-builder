<template>
    <div :class="className()" v-if="is_sidebar_expanded">
        <ul v-if="!onlyBorder">
            <li v-if="is_movable" class="upb-move-element"><i class="mdi mdi-cursor-move"></i></li>
            <li>
                <span v-text="model._upb_options.element.name"></span>
                <span v-if="!is_enabled" v-text="`- ( ${l10n.disabled} )`"></span>
            </li>
            <li v-if="has_contents && contents" @click.prevent="openContentsPanel()"><i class="mdi mdi-book-open"></i></li>
            <li v-if="has_settings && settings" @click.prevent="openSettingsPanel()"><i class="mdi mdi-settings"></i></li>
        </ul>
    </div>
</template>
<script src="./UPBPreviewMiniToolbar.js"></script>
