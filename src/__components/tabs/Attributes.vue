<template>
    <ul>

        Attributes

        <br>

        {{ $route.params }}



    </ul>
</template>
<script>
    import Vue from 'vue';

    export default {
        name  : 'attributes',
        props : ['model'],
        created() {
           // console.log(this.$router.options.routes)
            console.log( this.$route )
        },
    }
</script>
