<template>
    <div id="upb-sidebar-header">
        <ul>
            <li class="btn-close"><a href="#" :title="l10n.close"><i class="mdi mdi-window-close"></i></a></li>
            <ul class="tab-wrapper">
                <component v-for="item in model" @changedActive="removeActive()" :model="item" is="upb-sidebar-header-item"></component>
            </ul>
            <li :class="[{ active: isDirty() }, 'btn-save']"><a @click.prevent="save()" href="#" :title="l10n.save"><i class="mdi mdi-content-save-all"></i></a></li>
        </ul>
    </div>
</template>
<style src="../scss/upb-sidebar-header.scss" lang="sass"></style>
<script>

    import Vue from 'vue';
    import store from '../store'

    import UPBSidebarHeaderItem from './UPBSidebarHeaderItem.vue'
    Vue.component('upb-sidebar-header-item', UPBSidebarHeaderItem);

    export default {
        name  : 'upb-sidebar-header',
        props : ['index', 'model'],

        data(){
            return {
                l10n : store.l10n
            }
        },

        methods : {

            removeActive(){
                this.model.map(function (item) {
                    item.active = false
                });
            },

            save(){
                if (this.isDirty()) {
                    store.saveState();
                }
            },

            isDirty(){
                return store.isDirty();
            }
        }
    }
</script>
