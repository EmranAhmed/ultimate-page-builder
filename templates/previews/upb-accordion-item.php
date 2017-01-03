<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

    <upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>

    <div v-html="model.contents"></div>

</div>