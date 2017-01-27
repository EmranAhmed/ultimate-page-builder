<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="isEnabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element :style="backgroundVariables">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <!--  send ajax req and get it :) -->
    <div v-html="contents"></div>
</div>