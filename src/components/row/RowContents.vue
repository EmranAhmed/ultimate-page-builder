<template>
    <ul class="row-contents-layout">

        <li class="row-grid-screen-sizes-title" v-text="grid.deviceSizeTitle"></li>

        <li class="row-grid-screen-sizes">
            <ul>
                <li v-for="device in devices" :class="[{'active-device':device.active, current:device.current}]" @click.prevent="currentDevice(device)" @dblclick.prevent="toggleDevice(device)"
                    :title="device.title">
                    <i :class="device.icon"></i>
                </li>
            </ul>
        </li>

        <li class="row-grid-title" v-text="layoutTitle"></li>

        <li class="row-grid-layouts-wrapper">

            <a v-for="layout in columnLayouts()" @click.prevent="changeColumnLayout(layout)" :class="columnLayoutClass(layout)" href="#">
                <span v-for="item in miniColumns(layout.value)" :class="miniColumnItemClass(item)"></span>
            </a>

            <a class="manual" @click.prevent="openManualInput()" href="#">
                <span class="manual" v-text="l10n.column_manual"></span>
            </a>

        </li>

        <li v-show="showManualInput" class="row-grid-column">
            <div class="row-grid-column-input">
                <input v-model.lazy="selectedColumnLayout" type="text">
                <div v-if="showRatioSuggestion" class="suggestionMessage" v-text="ratioSuggestionMessage"></div>
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
    import math from 'mathjs';
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

                l10n : store.l10n,
                grid : store.grid,

                breadcrumb             : store.breadcrumb,
                showHelp               : false,
                showSearch             : false,
                sortable               : {
                    handle      : '> .tools > .handle',
                    placeholder : "upb-sort-placeholder",
                    axis        : 'y'
                },
                searchQuery            : '',
                selectedColumnLayout   : null,
                showManualInput        : false,
                showRatioSuggestion    : false,
                ratioSuggestionMessage : '',
                devices                : []
            }
        },

        computed : {

            layoutTitle(){
                return sprintf(this.l10n.column_layout, this.model.attributes.title);
            },

            sortTitle(){
                return sprintf(this.l10n.column_sort, this.model.attributes.title);
            },

            panelClass(){
                return [`upb-${this.model.tag}-panel`, `upb-panel-wrapper`].join(' ');
            },

        },

        updated(){
            //console.log('updated');
        },
        created(){
            this.setSelectedColumnLayout();
            this.devices = this.getDevices();
        },

        watch : {
            selectedColumnLayout(newValue){
                this.showRatioSuggestion = false;
                this.validateColumnInput(newValue);
            }
        },

        methods : {

            getDevices(){
                let grid = extend(true, {}, this.grid);
                return grid.devices.map(function (d) {

                    // array like because of active doesn't exists? then what?
                    d['active']  = (d.id == grid.defaultDeviceId) ? true : false;
                    d['current'] = (d.id == grid.defaultDeviceId) ? true : false;

                    return d;
                });
            },

            toggleDevice(device){
                device.active = !device.active;
            },

            currentDevice(device){

                this.devices.map(function (d) {
                    d.current = false;
                });

                device.current = true;
            },

            validateColumnInput(newValue){
                try {

                    // I know that ES6 have arrow function but my IDE in .vue extension does not support it :(

                    let totalGrid = newValue.split('+').map(function (i) {return i.trim()});

                    let gridArray = totalGrid.map(function (i) {
                        return parseInt(i.split(':')[0].trim());
                    });

                    let gridValueCount = totalGrid.reduce(function (old, i) {
                        let col = i.split(':')[0].trim();
                        return old + parseInt(col);
                    }, 0);

                    let totalGridValue = totalGrid.reduce(function (old, i) {
                        let ratio = i.split(':')[1].trim();
                        return old + parseInt(ratio);
                    }, 0);

                    let grid = totalGridValue / totalGrid.length;

                    if (grid == gridValueCount) {

                        // suggession msg

                        this.ratioSuggestion(grid, gridArray, gridValueCount);

                    }
                    else {
                        // errors
                    }

                    //console.log(ratio);
                    //console.log(items);

                } catch (e) {

                }
            },

            ratioSuggestion(grid, gridArray, gridValueCount){
                // I know that ES6 have spread operator but my IDE in .vue extension does not support
                // es6 features :(
                // math.gcd(...itemArray)

                //  A ratio can be simplified by dividing both sides of the ratio by the Highest Common Factor (HCF). I mean greatest common divisor :D

                let itemArray = gridArray.slice(0, gridArray.length);

                itemArray.push(gridValueCount);

                // console.log(itemArray);

                let common = math['gcd'].apply(this, itemArray);
                if (common > 1) {

                    itemArray.pop();

                    let simplifiedRatio = gridValueCount / common;

                    let simplifiedGrid = itemArray.map(function (i) {
                        return (i / common) + ":" + simplifiedRatio;
                    });

                    this.ratioSuggestionMessage = sprintf(this.grid.simplifiedRatio, simplifiedGrid.join(' + '))

                    this.showRatioSuggestion = true;
                }
            },

            openManualInput(){
                this.showManualInput = !this.showManualInput;
            },

            columnLayouts(){
                return this.model._upb_options.tools.contents.map(function (layout, index) {
                    layout['active'] = false;
                    return layout;
                });
            },

            setSelectedColumnLayout(){
                this.selectedColumnLayout = this.model.contents.map(function (column) {
                    return column.attributes[this.grid.defaultDeviceId].trim();
                }.bind(this)).join(' + ');
            },

            changeColumnLayout(layout){

                this.model._upb_options.tools.contents.map(function (layout, index) {
                    layout['active'] = false;
                    return layout;
                });

                layout.active = true;

                this.selectedColumnLayout = layout.value;
                //console.log(layout.value);
                //console.log(this.activeColumnLayout);

            },

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
                    (layout.value == this.selectedColumnLayout) ? 'active' : '',
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
