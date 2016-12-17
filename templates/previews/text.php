<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element :style="{'--background-color':model.attributes.background}">

	<upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>


	<!--  send ajax req and get it :) -->

	<!-- add css h1{ background-color:var(--background-color) } -->

	<div v-html="model.contents"></div>


</div>