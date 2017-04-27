<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element v-droppable v-ui-droppable :id="elementID" :class="addClass(generatedColumnClass)">

    <upb-preview-mini-toolbar :showDelete="false" :parent="parent" :model="model"></upb-preview-mini-toolbar>

    <component v-for="(content, index) in model.contents" :key="index" v-if="isElementRegistered(content.tag)" :index="index" :parent="model" :model="content" :is="content._upb_options.preview.component"></component>

    <a v-show="sidebarExpanded" href="#" @click.prevent="openElementsPanel()" class="upb-add-element-message-regular" v-text="messages.addElement"></a>

</div>