<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

    <upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>


    <!--  send ajax req and get it :) -->

    <!-- add css h1{ background-color:var(--background-color) } -->

    <div v-if="!model.attributes.id" v-text="model._upb_options.meta.messages.chooseForm"></div>
    <div v-else class="ajax-result"></div>


</div>