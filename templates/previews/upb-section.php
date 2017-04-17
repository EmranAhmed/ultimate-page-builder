<?php defined( 'ABSPATH' ) or die( 'Keep Silent' ); ?>

<div v-show="enabled" :id="addID()" :class="addClass(attributes['background-type']=='gradient'?'gradient':'')" v-preview-element :style="inlineStyle({'--sections-gap': attributes.space.join(' ') })">
    <upb-preview-mini-toolbar :parent="parent" :model="model"></upb-preview-mini-toolbar>
    <!--    <pre>
         {{ attributes }}
        </pre>-->
    <component v-for="(content, index) in contents" :index="index" :parent="model" :model="content" :is="content._upb_options.preview.component"></component>
</div>