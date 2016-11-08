<template>

    <ul :class="panelClass" id="upb-panel-wrapper">

        <li id="upb-panel-header">
            <span class="panel-heading">

                <span class="upb-breadcrumb" v-if="breadcrumb.length > 0">
                    loop a tag
                </span>

                <span v-else>{{ l10n.breadcrumbRoot }}</span>

                <strong class="panel-title">{{ model.title }}</strong>
            </span>

            <button @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                <i class="mdi mdi-help-circle-outline"></i>
            </button>

            <button @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
                <i class="mdi mdi-magnify"></i>
            </button>

        </li>

        <li id="upb-panel-meta">
            <div v-if="showHelp" v-html="model.help"></div>

            <div v-if="showSearch">
                <input results="5" autosave="upb-section-search" :placeholder="model.search" type="search">
            </div>
        </li>

        <li id="upb-panel-tools">
            <ul>
                <li v-for="tool in model.tools">
                    <a @click.prevent="callToolsAction($event, tool.action, tool)" href="#">
                        <i :class="tool.icon"></i>
                        <div v-text="tool.title"></div>
                    </a>
                </li>
            </ul>
        </li>

        <li id="upb-panel-contents">
            <ul class="upb-panel-contents-items">
                <component v-for="item in model.contents" :model="item" :is="itemComponent(item.id)"></component>
            </ul>
        </li>
    </ul>


    <!-- wrap with ul.sub-panel > li
                               <component v-for="item in model.contents" :model="item" :is="getPanel(item.id)"></component>
               -->

</template>
<style lang="sass"></style>
<script>

    import Vue from 'vue';
    import store from '../../store'

    // Section
    import Section from '../section/SectionItem.vue'
    Vue.component('section-item', Section);

    // Section Contents
    //import SectionContents from '../section/SectionContents.vue'
    //Vue.component('section-contents', SectionContents);

    // Section Settings
    //import SectionSettings from '../section/SectionSettings.vue'
    //Vue.component('section-settings', SectionSettings);

    export default {
        name  : 'sections-panel',
        props : ['index', 'model'],

        data(){
            return {
                l10n       : store.l10n,
                breadcrumb : store.breadcrumb,
                showHelp   : false,
                showSearch : false
            }
        },

        computed : {
            panelClass(){
                return `upb-${this.model.id}-panel`;
            }
        },

        methods : {

            itemComponent(id){
                return `${id}-item`;
            },

            contentsComponent(id){
                return `${id}-contents`;
            },
            settingsComponent(id){
                return `${id}-settings`;
            },

            toggleHelp(){
                this.showSearch = false;
                this.showHelp   = !this.showHelp;
            },

            toggleFilter(){
                this.showHelp   = false;
                this.showSearch = !this.showSearch;
                console.log(this.$el);
            },

            callToolsAction(event, action, tool){
                let data = tool.data ? tool.data : false;

                this[action](event, data)
            },

            addNewSection(e, data){
                let section = window.jQuery.extend(true, {}, data);
                this.model.contents.push(section);
                store.stateChanged();
            }
        }
    }
</script>
