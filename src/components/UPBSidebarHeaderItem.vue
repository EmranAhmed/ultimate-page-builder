<template>
    <li :class="{ active: model.active }">
        <a href="#" @click.prevent="activeTab()" :title="model.title"><i :class="model.icon"></i></a>
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
                this.$emit('changedActive', event.target.value)
                this.model.active = true
            },

            isSaved(){
                return !store.isSaved();
            }
        }
    }
</script>
