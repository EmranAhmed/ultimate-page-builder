<template>
    <li :class="itemClass()" v-draggable>
        <div class="icon-wrapper">
            <i :class="model._upb_options.element.icon"></i>
        </div>
        <div v-text="model._upb_options.element.name"></div>
    </li>

    <!--<li :class="itemClass()" v-draggable>
        <div class="icon-wrapper">
            <i :class="model._upb_options.element.icon"></i>
        </div>

        <div v-text="model._upb_options.element.name"></div>

    </li>-->
</template>
<style>

</style>
<script src="./ElementsList.js"></script>
