<template>
    <li>
        <ul class="tools">
            <li class="move handle"><i class="mdi mdi-cursor-move"></i></li>
            <li class="delete"><i class="mdi mdi-delete"></i></li>
            <li class="disable"><i class="mdi mdi-eye"></i></li>
            <li class="edit edit-child"><i class="mdi mdi-pencil"></i></li>
            <li class="settings edit-settings"><i class="mdi mdi-settings"></i></li>

        </ul>
        <div>
            {{ model.title }}
        </div>

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
