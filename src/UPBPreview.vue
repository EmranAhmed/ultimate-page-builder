<template>
    <div id="upb-preview" class="upb-wrapper">
        {{ $data }}
    </div>
</template>
<style src="./scss/upb-preview.scss" lang="sass"></style>
<script>
    import Vue from 'vue';

    export default {
        name : 'upb-preview',
        data(){
            return this.$root.$data
        }
    }
</script>
