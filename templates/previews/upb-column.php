<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element v-droppable v-ui-droppable :class="addClass()">

    <upb-preview-mini-toolbar :showDelete="false" :parent="parent" :model="model"></upb-preview-mini-toolbar>

    <component v-for="(content, index) in model.contents" v-if="isElementRegistered(content.tag)" :index="index" :parent="model" :model="content" :is="content._upb_options.preview.component"></component>

    <div v-show="sidebarExpanded">
        <a href="#" @click.prevent="openElementsPanel()" class="upb-add-element-message-regular" v-text="model._upb_options.meta.messages.addElement"></a>
    </div>
</div>