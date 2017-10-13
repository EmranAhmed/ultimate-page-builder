<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass()" v-ui-draggable v-preview-element>

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <div class="mailchimp-form-title" v-text="attributes.text"></div>
    <div v-if="!ajaxContents" v-text="messages.create"></div>
    <div v-else v-html="ajaxContents"></div>
</div>