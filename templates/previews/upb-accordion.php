<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

    <upb-preview-mini-toolbar :model="model"></upb-preview-mini-toolbar>

    <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>

    <a href="#" @click.prevent="openElementItemsPanel(model._upb_options._keyIndex)" class="upb-add-element-message" v-if="!hasContents" v-text="model._upb_options.meta.messages.addElement"></a>
</div>


