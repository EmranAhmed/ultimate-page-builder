<template>
    <li :class="{ active: model.active }">
        <a href="#" @click.prevent="activeTab()" :title="model.title"><i :class="model.icon"></i></a>
    </li>
</template>
<style lang="sass">
    @import "../../assets/scss/variables"
</style>
<script>

    import store from '../store'

    export default {
        name  : 'upb-sidebar-header-item',
        props : ['index', 'model'],
        data(){
            return {
                changes : store.isDirty()
            }
        },

        methods : {

            activeTab(){
                this.$emit('changedActive', event.target.value);
                this.model.active = true
            },

            isDirty(){
                return store.isDirty();
            }
        }
    }
</script>
