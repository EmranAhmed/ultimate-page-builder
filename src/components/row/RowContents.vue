<template>
    <ul class="row-contents-layout">


        <li>
            {{ layoutTitle }}
        </li>

        <li class="row-grid-layouts-wrapper">

            <a v-for="layout in defaultLayouts" @click.prevent="" :class="columnLayoutClass(layout)" href="#">
                <span v-for="item in miniColumns(layout.value)" :class="miniColumnItemClass(item)" v-text="item"></span>
            </a>

            <a class="manual" @click.prevent="" href="#">
                <span class="manual" v-text="l10n.column_manual"></span>
            </a>

        </li>

        <li class="row-grid-column">
            <div id="row-grid-column-input">
                <input v-model="activeColumnLayout" :value="activeColumnLayout" type="text"><input type="button" :value="l10n.create">
            </div>
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
    // import RowList from '../row/RowList.vue';

    Vue.use(Sortable);

    // Row List
    //Vue.component('row-list', RowList);

    export default {
        name  : 'row-contents',
        props : ['index', 'model'],

        data(){
            return {
                showChild      : false,
                childId        : null,
                childComponent : '',

                l10n        : store.l10n,
                grid        : store.grid,
                breadcrumb  : store.breadcrumb,
                showHelp    : false,
                showSearch  : false,
                sortable    : {
                    handle      : '> .tools > .handle',
                    placeholder : "upb-sort-placeholder",
                    axis        : 'y'
                },
                searchQuery : '',

                activeColumnLayout : ''
            }
        },

        computed : {

            layoutTitle(){
                return sprintf(this.l10n.column_layout, this.model.attributes.title);
            },

            sortTitle(){
                return sprintf(this.l10n.column_sort, this.model.attributes.title);
            },

            defaultLayouts(){
                return this.model._upb_options.tools.contents.map(function (layout, index) {

                    //if( this.grid.defaultDeviceId )
                    // layout['active'] = (index == 0) ? true : false;
                    layout['active'] = false;
                    return layout;
                });
            },

            panelClass(){
                //return [`upb-${this.model.id}-panel`, this.currentPanel ? 'current' : ''].join(' ');
                return [`upb-${this.model.tag}-panel`, `upb-panel-wrapper`].join(' ');
            },

            activeColumnLayout(){
                return this.model.contents.map(function (column) {
                    return column.attributes[this.grid.defaultDeviceId].trim();
                }.bind(this)).join(' + ');
            }
        },

        methods : {

            miniColumns(columns){
                return columns.split('+').map(function (i) {
                    return i.trim();
                });
            },
            miniColumnItem(item){
                return item.split(':')[0].trim();
            },
            miniColumnItemClass(item){
                let i = item.split(':')[0].trim();
                return `grid-item-${i}`;
            },

            columnLayoutClass(layout){
                return [
                    (layout.value == this.activeColumnLayout) ? 'active' : '',
                    layout.class
                ].join(' ');
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
                }
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

                this.clearPanel();

                console.log(index);

                //this.showChild      = true;
                this.childId        = index;
                //this.rowId          = index;
                this.childComponent = 'row-contents-panel';
                // this.breadcrumb.push(this.model.title);
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
                let section = extend(true, {}, data);

                section.attributes.title = sprintf(section.attributes.title, (this.model.contents.length + 1));

                this.model.contents.push(section);
                store.stateChanged();
            }
        }
    }
</script>
