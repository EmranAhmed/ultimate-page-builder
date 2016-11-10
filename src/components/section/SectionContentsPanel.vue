<template>
    <ul :class="panelClass">

        <li v-if="!showChild" class="upb-panel-header-wrapper">
            <ul>
                <li class="upb-panel-header">

                    <a href="" class="back" @click.prevent="back()">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>

                    <div class="panel-heading-wrapper">
                        <div class="panel-heading">
                            <div class="upb-breadcrumb">
                                <ul>
                                    <li class="breadcrumb" v-if="breadcrumb.length > 0" v-for="b in breadcrumb">{{ b }}</li>
                                    <li class="no-breadcrumb" v-else>{{ l10n.breadcrumbRoot }}</li>
                                </ul>
                            </div>

                            <div class="panel-title">{{ model.title }}</div>
                        </div>

                        <button @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>

                        <button @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </li>

                <li class="upb-panel-meta">
                    <div v-if="showHelp" v-html="model.help"></div>

                    <div v-if="showSearch">
                        <input v-model="searchQuery" :placeholder="model.search" type="search">
                    </div>
                </li>

                <li class="upb-panel-tools">
                    <ul>
                        <li v-for="tool in model.tools.contents">
                            <a @click.prevent="callToolsAction($event, tool.action, tool)" href="#">
                                <i :class="tool.icon"></i>
                                <div v-text="tool.title"></div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>

        <li v-if="!showChild" class="upb-panel-contents">
            <ul class="upb-panel-contents-items" v-sortable="sortable">
                <component v-for="(item, index) in contents" @showSettingsPanel="openSettingsPanel(index)" @showContentsPanel="openContentPanel(index)" @deleteItem="deleteItem(index)"
                           :model="item" @cloneItem="cloneItem(index, item)" :is="listPanel(item.id)"></component>
            </ul>
        </li>
    </ul>
</template>
<style lang="sass"></style>
<script>

    import Vue, { util } from 'vue';

    import store from '../../store'

    import Sortable from '../../js/vue-sortable'
    import extend from 'extend';
    import {sprintf} from 'sprintf-js';
    import RowList from '../row/RowList.vue';

    Vue.use(Sortable);

    // Row List
    Vue.component('row-list', RowList);

    export default {
        name  : 'section-contents-panel',
        props : ['index', 'model'],

        data(){
            return {
                showChild      : false,
                childId        : null,
                childComponent : '',

                l10n        : store.l10n,
                breadcrumb  : store.breadcrumb,
                showHelp    : false,
                showSearch  : false,
                sortable    : {
                    handle      : '> .tools > .handle',
                    placeholder : "upb-sort-placeholder",
                    axis        : 'y'
                },
                searchQuery : ''
            }
        },

        computed : {

            panelClass(){
                //return [`upb-${this.model.id}-panel`, this.currentPanel ? 'current' : ''].join(' ');
                return [`upb-${this.model.id}-panel`, `upb-panel-wrapper`].join(' ');
            },

            currentPanel(){
                // return this.breadcrumb[this.breadcrumb.length - 1] == this.model.id;
            },

            contents(){
                let query = this.searchQuery.toLowerCase().trim();
                if (query) {
                    return this.model.contents.filter(function (data) {
                        return new RegExp(query, 'gui').test(data.title.toLowerCase().trim())
                    })
                }
                else {
                    return this.model.contents;
                }
            }
        },

        methods : {

            showSettingsPanel(){
                this.$emit('showSettingsPanel')
            },

            back(){
                this.$emit('onBack')
            },

            backed(){
                this.breadcrumb.pop();
                this.showChild      = false;
                this.childId        = null;
                this.childComponent = '';
            },

            clearPanel(){
                this.breadcrumb.pop();
                this.childComponent = '';
                //this.showChild      = false;
            },

            openContentsPanel(index){

                this.clearPanel();

                this.showChild      = true;
                this.childId        = index;
                this.childComponent = 'row-contents-panel';
                this.breadcrumb.push(this.model.title);
            },

            openSettingsPanel(index){

                this.clearPanel();

                this.showChild      = true;
                this.childId        = index;
                this.childComponent = 'row-settings-panel';
                this.breadcrumb.push(this.model.title);
            },

            singleModel(){
                return this.model.contents[this.childId];
            },

            listPanel(id){
                return `${id}-list`
            },

            deleteItem(index){
                this.model.contents.splice(index, 1);
                store.stateChanged();
            },

            cloneItem(index, item){
                let cloned = extend(true, {}, item);

                cloned.title = `Clone of ${cloned.title}`

                this.model.contents.splice(index + 1, 0, cloned);
                store.stateChanged();
            },

            onUpdate(e, values){


                //###
                //this.contents.splice(values.newIndex, 0, this.contents.splice(values.oldIndex, 1).pop());
                store.stateChanged();

                //### If you Need to modify this.model.contents then you should use this code :)
                let list = extend(true, [], this.model.contents);

                list.splice(values.newIndex, 0, list.splice(values.oldIndex, 1).pop());

                Vue.delete(this.model, 'contents');

                this.$nextTick(function () {
                    Vue.set(this.model, 'contents', extend(true, [], list));
                });

                // store.stateChanged();
            },

            onStart(e){
                this.searchQuery = ''
            },

            toggleHelp(){
                this.showSearch = false;
                this.showHelp   = !this.showHelp;
            },

            toggleFilter(){
                this.showHelp   = false;
                this.showSearch = !this.showSearch;

                this.$nextTick(function () {
                    if (this.showSearch) {
                        this.$el.querySelector('input[type="search"]').focus()
                    }
                });
            },

            callToolsAction(event, action, tool){

                let data = tool.data ? tool.data : false;

                if (!this[action]) {
                    util.warn(`You need to implement ${action} method.`, this);
                }
                else {
                    this[action](event, data);
                }
            },

            addNew(e, data){
                let section   = extend(true, {}, data);
                section.title = sprintf(section.title, (this.model.contents.length + 1));

                this.model.contents.push(section);
                store.stateChanged();
            }
        }
    }
</script>
