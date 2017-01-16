<template>
    <div :class="className()" v-if="is_sidebar_expanded">
        <ul v-if="!onlyBorder">
            <li v-if="is_movable" class="upb-move-element upb-element-tool-icon"><i class="mdi mdi-cursor-move"></i></li>
            <li class="upb-element-name" v-text="model._upb_options.element.name"></li>
            <li class="upb-element-tool-icon" v-if="has_contents && contents" @click.prevent="openContentsPanel()"><i class="mdi mdi-table-edit"></i></li>
            <li class="upb-element-tool-icon" v-if="has_settings && settings" @click.prevent="openSettingsPanel()"><i class="mdi mdi-settings"></i></li>
            <li class="upb-element-tool-icon" v-if="showDelete" @click.prevent="removeElement()"><i class="mdi mdi-delete-forever"></i></li>
        </ul>
    </div>
</template>
<script src="./UPBPreviewMiniToolbar.js"></script>
