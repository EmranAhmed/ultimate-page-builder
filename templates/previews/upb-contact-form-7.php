<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element :style="backgroundVariables">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>

    <div v-if="!attributes.id" v-text="messages.chooseForm"></div>

    <div v-else v-html="ajaxContents"></div>
</div>