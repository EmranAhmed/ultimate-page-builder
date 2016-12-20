<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-preview-element :style="{'--background-color':model.attributes['background-color']}">
	<upb-preview-mini-toolbar :model="model"></upb-preview-mini-toolbar>


	<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>

</div>