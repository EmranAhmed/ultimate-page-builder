<!--<template src="./template.html"></template>
<style src="./style.css"></style>
<script src="./script.js"></script>-->
<template>
    <div id="upb-sidebar">
        <div id="progress-bar"></div>


        <div id="upb-sidebar-header">
            <ul>
                <li class="btn-close"><a href="#" :title="store.l10n.close"><i class="mdi mdi-window-close"></i></a></li>
                <ul class="tab-wrapper">
                    <router-link to="/sections" tag="li" active-class="active"><a>Sections</a></router-link>
                    <router-link to="/settings" tag="li" active-class="active"><a>Settings</a></router-link>

                </ul>
                <li :class="[{ active: store.isDirty() }, 'btn-save']"><a @click.prevent="save()" href="#" :title="store.l10n.save"><i class="mdi mdi-content-save-all"></i></a></li>
            </ul>
        </div>




        <div id="upb-sidebar-contents">
            <router-view :model="store.tabs"></router-view>
        </div>
    </div>
</template>
<style src="./scss/upb-sidebar.scss" lang="sass"></style>
<script>
    import Vue from 'vue';

    export default {
        name : 'app',
        data(){
            return this.$root.$data
        }
    }
</script>