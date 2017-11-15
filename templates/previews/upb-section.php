<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass(gradientBackgroundClass)" v-preview-element :style="inlineStyle({ '--section-margin' : getSpacingInputValue('margin'), '--section-padding' : getSpacingInputValue('padding') })">

    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
        <!--<pre>
         {{ generatedAttributes }}
         {{ attributes }}
         {{ getMediaImageSrc(attributes.image) }}
        </pre>-->
    <component v-for="(content, index) in contents" :key="index" :index="index" :parent="model" :model="content" :is="content._upb_options.preview.component"></component>
</div>