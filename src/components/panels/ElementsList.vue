<template>
    <li :class="itemClass()" v-draggable="model._upb_options.element.tag">
        <div v-if="model._upb_options.element.tag" :class="elementTagClass" v-text="model._upb_options.element.tag"></div>
        <div class="icon-wrapper">
            <i :class="model._upb_options.element.icon"></i>
        </div>
        <div class="element-name" v-text="model._upb_options.element.name"></div>
    </li>
</template>
<script src="./ElementsList.js"></script>