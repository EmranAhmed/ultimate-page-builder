<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="isEnabled" :id="addID()" :class="addClass()" v-preview-element>

    <a href="#" class="upb-accordion-toggle" v-text="model.attributes.title"></a>
    <div :class="{ active: model.attributes.active, 'upb-accordion-content': true }">
        <div v-html="model.contents"></div>
    </div>

</div>