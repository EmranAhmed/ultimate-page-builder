<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<section @mouseover.self="activeFocus()" @mouseout.self="removeFocus()" @click.self="openSettingsPanel()">

	SECTION

	{{ model.attributes }}

	<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="content._upb_options.preview.component"></component>

</section>