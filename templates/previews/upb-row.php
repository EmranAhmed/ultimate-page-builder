<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>
<div v-show="enabled" :class="containerClass()">
    <div v-preview-element :id="addID()" :class="addClass()">
        <upb-preview-mini-toolbar :contents="false" :parent="parent" :model="model"></upb-preview-mini-toolbar>
        <component v-for="(content, index) in contents" :index="index" :parent="model" :model="content" :is="content._upb_options.preview.component"></component>
    </div>
</div>