<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>


<div :class="containerClass">

	<div v-preview-element :class="rowClass">

		<upb-preview-mini-toolbar :contents="false" :model="model"></upb-preview-mini-toolbar>

		<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>

	</div>


</div>


