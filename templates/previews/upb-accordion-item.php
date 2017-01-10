<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>
<!--    <upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>
-->

    <!--{{ parent.attributes }}-->

    <a href="#" class="upb-accordion-toggle" v-text="model.attributes.title"></a>
    <div :class="{ active: model.attributes.active, 'upb-accordion-content': true }">
        <div v-html="model.contents"></div>
    </div>

</div>