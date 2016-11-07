<template>
    <li>
        {{ model.title }}
        <ul>
            <li>Settings</li>
        </ul>
    </li>
</template>
<style lang="sass">

</style>
<script>

    import Vue from 'vue';
    import store from '../../store'

    export default {
        name    : 'section-item',
        props   : ['index', 'model'],
        methods : {
            getPanel(id){
                return `${id}-panel`;
            }
        }
    }
</script>
