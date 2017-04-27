<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element :style="backgroundVariables">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>

    <div class="upb-tab">
        <ul class="upb-tab-items">
            <li v-for="(content, index) in contents" :key="index" @click.prevent="openElementSettingsPanel(content._upb_options._keyIndex)" v-if="isElementRegistered(content.tag)" :class="{ active: content.attributes.active, 'upb-tab-item': true }" v-text="content.attributes.title"></li>
        </ul>

        <div class="upb-tab-contents">
            <div v-for="(content, index) in contents" :key="index" v-if="isElementRegistered(content.tag)" :class="{ active: content.attributes.active, 'upb-tab-content': true }">
                <div v-html="content.contents"></div>
                <div style="clear: both"></div>
            </div>
            <a href="#" @click.prevent="openElementItemsPanel(keyIndex)" class="upb-add-element-message" v-else v-text="messages.addElement"></a>
        </div>

        <a v-if="!hasContents" href="#" @click.prevent="openElementItemsPanel(keyIndex)" class="upb-add-element-message" v-text="messages.addElement"></a>
    </div>
</div>