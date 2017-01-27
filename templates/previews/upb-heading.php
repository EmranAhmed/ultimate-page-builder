<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="isEnabled" v-ui-draggable v-preview-element :id="addID()" :class="addClass()" :style="inlineStyle({ 'text-align': attributes.align })">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>

    <h1 v-if="attributes.type=='h1'" v-html="contents"></h1>
    <h2 v-if="attributes.type=='h2'" v-html="contents"></h2>
    <h3 v-if="attributes.type=='h3'" v-html="contents"></h3>
    <h4 v-if="attributes.type=='h4'" v-html="contents"></h4>
    <h5 v-if="attributes.type=='h5'" v-html="contents"></h5>
    <h6 v-if="attributes.type=='h6'" v-html="contents"></h6>
</div>