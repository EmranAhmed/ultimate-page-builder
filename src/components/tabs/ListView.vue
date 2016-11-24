<template>
    <ul>

        List View

        <br>

        {{ $route.params }}



    </ul>
</template>
<script>
    import Vue from 'vue';

    export default {
        name  : 'list-view',
        props : ['model'],
        beforeCreate() {
           // this.$options.computed.value = function() {}
        },
        created() {
            //console.log(this.$router.options.routes)
            console.log(this.$route)
        },
    }
</script>
