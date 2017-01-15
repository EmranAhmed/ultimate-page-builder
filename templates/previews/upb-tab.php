<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="isEnabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element :style="backgroundVariables">

    <upb-preview-mini-toolbar :model="model"></upb-preview-mini-toolbar>

    <div class="upb-tab">

        <ul class="upb-tab-items">
            <li v-for="(content, index) in model.contents" v-if="isElementRegistered(content.tag)" :class="{ active: content.attributes.active, 'upb-tab-item': true }" v-text="content.attributes.title"></li>
        </ul>

        <div class="upb-tab-contents">
            <div v-for="(content, index) in model.contents" v-if="isElementRegistered(content.tag)" :class="{ active: content.attributes.active, 'upb-tab-content': true }" v-html="content.contents"></div>

            <a href="#" @click.prevent="openElementItemsPanel(model._upb_options._keyIndex)" class="upb-add-element-message" v-else v-text="model._upb_options.meta.messages.addElement"></a>
        </div>

        <a href="#" @click.prevent="openElementItemsPanel(model._upb_options._keyIndex)" class="upb-add-element-message" v-if="!hasContents" v-text="model._upb_options.meta.messages.addElement"></a>
    </div>
</div>