<template>
    <ul :class="panelClass">

        <li class="upb-panel-header-wrapper">
            <ul>
                <li class="upb-panel-header">

                    <a :title="l10n.back" href="" class="back" @click.prevent="back()">
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

                            <div class="panel-title">{{ model.attributes.title }}</div>
                        </div>

                        <button v-if="model._upb_options.help" @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>

                        <button v-if="model._upb_options.search" @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </li>

                <li class="upb-panel-meta">
                    <div v-if="showHelp" v-html="model._upb_options.help"></div>

                    <div v-if="showSearch">
                        <input v-model="searchQuery" :placeholder="model._upb_options.search" type="search">
                    </div>
                </li>

                <li class="upb-panel-tools">
                    <ul>
                        <li v-for="tool in model._upb_options.tools.contents">
                            <a @click.prevent="callToolsAction($event, tool.action, tool)" href="#">
                                <i :class="tool.icon"></i>
                                <div v-text="tool.title"></div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="upb-panel-contents">
            <ul class="upb-panel-contents-items" v-sortable="sortable">
                <component v-for="(item, index) in contents" :index="index" :selected="childId" @showSettingsPanel="openSettingsPanel(index)" @showContentsPanel="openContentsPanel(index)"
                           @deleteItem="deleteItem(index)"
                           :model="item" @cloneItem="cloneItem(index, item)" :is="listPanel(item.tag)"></component>
            </ul>

            <component v-for="(item, index) in contents" v-show="isCurrentRow(index)" :index="index" :model="item" :is="childComponent"></component>

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
    import RowContents from '../row/RowContents.vue';

    Vue.use(Sortable);

    // Row List
    Vue.component('row-list', RowList);
    Vue.component('row-contents', RowContents);

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
                searchQuery : '',
            }
        },

        computed : {

            panelClass(){
                //return [`upb-${this.model.id}-panel`, this.currentPanel ? 'current' : ''].join(' ');
                return [`upb-${this.model.tag}-panel`, `upb-panel-wrapper`].join(' ');
            },

            contents(){

                let query = this.searchQuery.toLowerCase().trim();

                if (query) {
                    return this.model.contents.filter(function (data) {
                        return new RegExp(query, 'gui').test(data.attributes.title.toLowerCase().trim())
                    })
                }
                else {
                    return this.model.contents;
                }
            }
        },

        created(){
            this.loadContents()
        },

        methods : {

            isCurrentRow(index){
                return this.childId == index;
            },

            loadContents(){
                if (this.model.contents.length > 0) {
                    this.$progressbar.show();
                    store.upbElementOptions(this.model.contents, function (data) {

                        this.$nextTick(function () {
                            Vue.set(this.model, 'contents', extend(true, [], data));
                            this.afterContentLoaded();
                        });

                        this.$progressbar.hide();
                    }.bind(this), function (data) {
                        console.log(data);
                        this.$progressbar.hide();
                    }.bind(this));
                }
            },

            afterContentLoaded(){
                if (this.model.contents.length > 0) {
                    this.childId = 0;
                    this.openContentsPanel(this.childId);
                }
            },

            afterSort(values){
                this.childId   = values.newIndex;
                this.showChild = true;
            },

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

                //this.clearPanel();

                this.showChild      = true;
                this.childId        = index;
                this.childComponent = 'row-contents';
                //this.breadcrumb.push(this.model.title);
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
                let cloned              = extend(true, {}, item);
                cloned.attributes.title = `Clone of ${cloned.attributes.title}`
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
                    this.afterSort(values);
                });

                // store.stateChanged();
            },

            onStart(e){
                this.searchQuery = '';
                this.showChild   = false;
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
                let section = extend(true, {}, data);

                section.attributes.title = sprintf(section.attributes.title, (this.model.contents.length + 1));

                this.model.contents.push(section);
                store.stateChanged();
            }
        }
    }

</script>
