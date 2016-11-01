<template>
    <li :class="{ active: model.active }">

        <a href="#" @click="activeTab" :title="model.title"><i :class="model.icon"></i></a>
    </li>
</template>
<style src="../scss/upb-sidebar-header-item.scss" lang="sass"></style>
<script>


    import store from '../store'

    export default {
        name  : 'upb-sidebar-header-item',
        props : ['index', 'model'],
        data(){
            return {
                changes : !store.status.saved
            }
        },

        methods : {

            activeTab(){
                this.$parent.$options.propsData.model.map(function (item) {
                    item.active = false
                });

                this.model.active = true
            },

            isSaved(){
                return !store.isSaved();
            },

            changeIt(){
                store.changeStatus();
                store.changeBaz();
            },
            changeFoo(){
                //store.changeStatus();
                store.changeBaz();
            },
        }
    }
</script>
