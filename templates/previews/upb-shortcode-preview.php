<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>
<div v-show="enabled" :class="addPreviewClass(deviceHiddenClasses)" v-ui-draggable v-preview-element>
    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <div v-html="ajaxContents"></div>
</div>