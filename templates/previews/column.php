<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>
<div v-preview-element v-droppable class="upb-column-droppable">

	Column {{ model.attributes }}


	<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>

</div>