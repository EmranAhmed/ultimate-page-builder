<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

    <upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>

    <div v-if="!model.attributes.id" v-text="model._upb_options.meta.messages.chooseForm"></div>
    <div v-else class="ajax-result"></div>
</div>