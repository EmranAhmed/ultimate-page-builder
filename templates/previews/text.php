<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

	Text {{ model.attributes }}

	<!--  send ajax req and get it :) -->
	<div v-html="model.contents"></div>


</div>