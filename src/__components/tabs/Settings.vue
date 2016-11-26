<template>
    <ul>

        Settings

        {{ $route.params }}

    </ul>
</template>
<script>
    import Vue from 'vue';

    export default {
        name  : 'settings',
        props : ['model']
    }
</script>
