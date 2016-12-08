<template>
    <div id="upb-preview" class="upb-wrapper">

        {{ settings }}

        <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>
    </div>
</template>
<script src="./UPBPreview.js"></script>