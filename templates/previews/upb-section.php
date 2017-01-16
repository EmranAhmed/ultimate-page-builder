<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="isEnabled" :id="addID()" :class="addClass()" v-preview-element :style="inlineStyle({'--margin-bottom': `${attributes.space}px`})">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <component v-for="(content, index) in model.contents" :index="index" :parent="model" :model="content" :is="content._upb_options.preview.component"></component>
</div>