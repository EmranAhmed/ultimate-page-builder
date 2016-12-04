<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div @mouseover="activeFocus()" @mouseout="removeFocus()" @click.self="openSettingsPanel(index)">

	ROW

	{{ model.attributes }}


	<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>



</div>