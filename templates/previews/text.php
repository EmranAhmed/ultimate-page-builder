<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

	<upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>


	<!--  send ajax req and get it :) -->
	<div v-html="model.contents"></div>


</div>