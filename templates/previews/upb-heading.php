<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" v-ui-draggable v-preview-element :class="addPreviewClass()">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>

    <h1 v-if="attributes.type=='h1'" :id="addID()" :class="addClass(false, false)" :style="inlineStyle({ 'text-align': attributes.align })" v-html="contents"></h1>
    <h2 v-if="attributes.type=='h2'" :id="addID()" :class="addClass(false, false)" :style="inlineStyle({ 'text-align': attributes.align })" v-html="contents"></h2>
    <h3 v-if="attributes.type=='h3'" :id="addID()" :class="addClass(false, false)" :style="inlineStyle({ 'text-align': attributes.align })" v-html="contents"></h3>
    <h4 v-if="attributes.type=='h4'" :id="addID()" :class="addClass(false, false)" :style="inlineStyle({ 'text-align': attributes.align })" v-html="contents"></h4>
    <h5 v-if="attributes.type=='h5'" :id="addID()" :class="addClass(false, false)" :style="inlineStyle({ 'text-align': attributes.align })" v-html="contents"></h5>
    <h6 v-if="attributes.type=='h6'" :id="addID()" :class="addClass(false, false)" :style="inlineStyle({ 'text-align': attributes.align })" v-html="contents"></h6>
</div>