<template>
    <div id="upb-preview" class="upb-wrapper">
        <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>
    </div>
</template>
<style src="./scss/upb-preview.scss" lang="sass"></style>
<script src="./UPBPreview.js"></script>