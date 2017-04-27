<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>
<div v-show="enabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element :style="backgroundVariables">
    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <!--  just use  preview shortcode to show parsed element -->
    <div v-html="contents"></div>
    <div style="clear: both"></div>
</div>