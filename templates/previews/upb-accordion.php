<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element :style="backgroundVariables">
    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <div class="upb-accordion">
        <component v-for="(content, index) in model.contents" :key="index" v-if="isElementRegistered(content.tag)" :parent="model" :index="index" :model="content" :is="content._upb_options.preview.component"></component>
        <a href="#" @click.prevent="openElementItemsPanel(keyIndex)" class="upb-add-element-message" v-else v-text="messages.addElement"></a>
        <a href="#" @click.prevent="openElementItemsPanel(keyIndex)" class="upb-add-element-message" v-if="!hasContents" v-text="messages.addElement"></a>
    </div>
</div>