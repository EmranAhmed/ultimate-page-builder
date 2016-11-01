<template>
    <div id="upb-sidebar-header">
        <ul>
            <li class="btn-close"><a href="#" title="Close"><i class="mdi mdi-window-close"></i></a></li>
            <ul class="tab-wrapper">
                <upb-sidebar-header-item v-for="item in model" :model="item"></upb-sidebar-header-item>
            </ul>
            <li :class="{ active: isSaved(), 'btn-save':true }"><a href="#" title="Save"><i class="mdi mdi-content-save-all"></i></a></li>
        </ul>
    </div>
</template>
<style src="../scss/upb-sidebar-header.scss" lang="sass"></style>
<script>

    import Vue from 'vue';
    import UPBSidebarHeaderItem from './UPBSidebarHeaderItem.vue'
    import store from '../store'

    Vue.component('upb-sidebar-header-item', UPBSidebarHeaderItem);

    export default {
        name  : 'upb-sidebar-header',
        props : ['index', 'model'],
        data(){
            return {
                changes : !store.status.saved
            }
        },
        watch : {
            title(value){
                store.changeStatus();
                console.log('title....');
                return value
            }
        },

        methods : {

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
