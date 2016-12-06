<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element>

	<upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>

	ROW

	{{ model.attributes }}


	<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>



</div>