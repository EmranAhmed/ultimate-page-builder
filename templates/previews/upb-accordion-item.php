<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass()" v-preview-element>
    <a href="#" :class="{ active: active, 'upb-accordion-item': true }" v-text="title"></a>
    <div :class="{ active: active, 'upb-accordion-content': true }">
        <div v-html="contents"></div>
    </div>
</div>