<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>
<div v-preview-element v-droppable :style="{'--background-color':model.attributes.background}">

    <upb-preview-mini-toolbar :model="model"></upb-preview-mini-toolbar>

    <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>

    <a href="#" @click.prevent="openElementsPanel()" class="upb-add-element-message" v-if="!hasContents" v-text="l10n.dropElementMessage"></a>
</div>