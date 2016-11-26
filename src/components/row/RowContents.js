import Vue, { util } from 'vue'

import store from '../../store'

import Sortable from '../../plugins/vue-sortable'

import extend from 'extend'

import {sprintf} from 'sprintf-js'

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

            breadcrumb           : store.breadcrumb,
            showHelp             : false,
            showSearch           : false,
            sortable             : {
                //handle      : '> .tools > .handle',
                placeholder : "upb-sort-placeholder",
                //axis        : 'y'
            },
            searchQuery          : '',
            selectedColumnLayout : {},
            showManualInput      : {},
            manualLayout         : {},
            devices              : []
        }
    },

    computed : {

        layoutOfTitle(){
            return sprintf(this.l10n.column_layout_of, this.model.attributes.title);
        },

        contents(){
            return this.model.contents

        }
    },

    created(){
        this.afterContentLoaded();
        this.devices = this.getDevices();
        this.setToolsForDevices();
        this.setSelectedColumnLayout();
        this.onSelectedColumnLayoutChange();
    },

    watch : {
        devices : {
            handler : function (val, oldVal) {
                // console.log(val, oldVal);
            },
            deep    : true
        }
    },

    methods : {

        loadContents(){
            this.$progressbar.show();
            store.upbElementOptions(this.model.contents, (data) => {

                this.$nextTick(function () {
                    Vue.set(this.model, 'contents', extend(true, [], data));
                    this.afterContentLoaded();
                });

                this.$progressbar.hide();
            }, function (data) {
                console.log(data);
                this.$progressbar.hide();
            });
        },

        afterContentLoaded(){
            if (this.model.contents.length > 0) {
                this.childId = 0;
            }
        },

        panelClass(){
            return [`upb-${this.model.tag}-panel`, `upb-panel-wrapper`].join(' ');
        },

        sortOrderClass(content, device){
            let layout = content.attributes[device.id].replace(':', '-');

            // We Implemented grid 12
            let upb_total_column = this.contents.length;
            let upb_split_column = parseInt(layout.split('-')[0]);
            let column           = Math.round(upb_total_column * upb_split_column);

            return `column-${layout} upb-mini-column upb-mini-column-${column}`;
        },

        columnLayoutTitle(content, device){
            return content.attributes[device.id]
        },

        onSelectedColumnLayoutChange(){
            this.devices.map((device)=> {

                this.$watch(`selectedColumnLayout.${device.id}`, (value) => {

                    let activeDevices    = this.devices.filter((d)=> !!d.active);
                    let totalColumns     = _.compact(activeDevices.map((d)=> this.selectedColumnLayout[d.id])).join(' + ').split('+');
                    let currentColLength = value.split('+').length;

                    if (activeDevices.length == 1) {
                        //
                        // console.log('Only One Device Using')
                    }

                    this.devices.map((d)=> {

                        let colLength = this.selectedColumnLayout[d.id].split('+').length;

                        d.reconfig = false;

                        if (device.active && d.active && activeDevices.length > 1 && d.id != device.id && currentColLength !== colLength) {
                            d.reconfig = true;
                        }
                    });

                    this.selectedColumnOperation(device, value);

                    //return this.model._upb_options.tools[deviceId];

                    this.isManualLayout(device, value);

                }, {deep : true});

            })
        },

        isManualLayout(device, value = false){

            if (!value) {
                value = this.selectedColumnLayout[device.id];
            }

            let isPredefined = this.model._upb_options.tools[device.id].filter((predefined) => {
                return predefined.value.trim() == value.trim()
            });

            return this.manualLayout[device.id] = (isPredefined.length <= 0) ? true : false;
            //
        },

        selectedColumnOperation(device, value){

            let runOperation  = !this.devices.some((d)=> {
                return d.reconfig == true;
            });
            let activeDevices = this.devices.filter((d)=> !!d.active);
            let totalColumns  = _.compact(activeDevices.map((d)=> this.selectedColumnLayout[d.id])).join(' + ').split('+');

            let shouldAddNewColumn = Math.round(totalColumns.length / activeDevices.length) > this.model.contents.length;
            let shouldRemoveColumn = Math.round(totalColumns.length / activeDevices.length) < this.model.contents.length;

            this.validateColumnInput(device, value);

            if (runOperation && shouldAddNewColumn && (totalColumns.length % activeDevices.length === 0)) {

                let columnNeedToAdd = Math.round(totalColumns.length / activeDevices.length) - this.model.contents.length;
                for (let i = 1; i <= columnNeedToAdd; i++) {
                    this.addNew(this.model._upb_options.tools.contents.new);
                }
            }

            if (runOperation && shouldRemoveColumn) {
                let columnNeedToRemove = this.model.contents.length - Math.round(totalColumns.length / activeDevices.length);
                let start              = Math.round(totalColumns.length / activeDevices.length);
                this.deleteItem(start, columnNeedToRemove);
            }

            this.changeDeviceColumnLayout(device);

            // this.model.contents

            // extend(true, {}, this.model._upb_options.tools.contents.new)
        },

        getDevices(){
            let grid       = extend(true, {}, this.grid);
            let hasCurrent = false;
            let lastIndex  = 0;

            let devices = grid.devices.map((device, index) => {

                device['active']             = false;
                device['current']            = false;
                device['reconfig']           = false;
                device['ratioSuggestion']    = false;
                device['ratioSuggestionMsg'] = '';

                this.model.contents.map((column) => {
                    let selected = column.attributes[device.id].trim();

                    if (selected) {
                        device.active = true;
                        lastIndex     = index;
                    }

                });

                device.current = (device.active && device.id == grid.defaultDeviceId) ? true : false;

                if (device.current) {
                    hasCurrent = true;
                }

                return device;
            });

            if (!hasCurrent) {
                devices[lastIndex].current = true;
            }

            return devices;
        },

        setToolsForDevices(){

            this.devices.map((device) => {
                this.model._upb_options.tools[device.id] = extend(true, [], this.model._upb_options.tools.contents.layouts);
            });

        },

        toggleDevice(device){
            device.active = !device.active;
            this.reConfigColumnNotice(device)
        },

        reConfigColumnNotice(device){

            let columns = this.selectedColumnLayout[device.id].trim();

            let activeDevices = this.devices.filter((d)=> !!d.active);

            let totalColumns = _.compact(activeDevices.map((device)=> this.selectedColumnLayout[device.id])).join(' + ').split(' + ');

            this.selectedColumnLayout[device.id] = columns;

            // no column layout selected.
            // so we should show re-config based on active / inactive.
            if (!columns) {
                device.reconfig = device.active ? true : false;
            }
            else {

                let currentColLength = columns.split('+').length;

                this.devices.map((d)=> {

                    let colLength = this.selectedColumnLayout[d.id].split('+').length;

                    d.reconfig = false;

                    if (device.active && d.active && activeDevices.length > 1 && d.id != device.id && currentColLength !== colLength) {
                        d.reconfig = true;
                    }

                });

            }

            this.changeDeviceColumnLayout(device);

        },

        changeDeviceColumnLayout(device){

            this.devices.map((d)=> {
                if (d.active) {
                    let columns = this.selectedColumnLayout[d.id].trim();

                    //console.log(d.id, columns);

                    columns.split('+').map((col, i)=> {
                        if (this.model.contents[i]) {
                            this.model.contents[i].attributes[d.id] = col.trim();
                        }

                    })
                }
            });

            store.stateChanged();
        },

        currentDevice(device){

            this.devices.map((d) => {
                d.current = false;
            });

            device.current = true;
        },

        validateColumnInput(device, value){

            //console.log(device, value);

            try {

                device.ratioSuggestion    = false;
                device.ratioSuggestionMsg = '';

                let totalGrid = value.split('+').map((i) => i.trim());

                let gridArray = totalGrid.map((i) => parseInt(i.split(':')[0].trim()));

                let gridValueCount = totalGrid.reduce((old, i) => {
                    let col = i.split(':')[0].trim();
                    return old + parseInt(col);
                }, 0);

                let totalGridValue = totalGrid.reduce((old, i)=> {
                    let ratio = i.split(':')[1].trim();
                    return old + parseInt(ratio);
                }, 0);

                let grid = totalGridValue / totalGrid.length;

                if (grid == gridValueCount) {

                    // suggession msg

                    this.ratioSuggestion(device, gridArray, gridValueCount);

                }
                else {
                    // errors
                }

                //console.log(ratio);
                //console.log(items);

            } catch (e) {
                console.log(e);
            }
        },

        gcd(input) {
            if (toString.call(input) !== "[object Array]")
                return false;
            var len, a, b;
            len = input.length;
            if (!len) {
                return null;
            }
            a = input[0];
            for (var i = 1; i < len; i++) {
                b = input[i];
                a = this.gcd_two(a, b);
            }
            return a;
        },

        gcd_two(x, y) {
            if ((typeof x !== 'number') || (typeof y !== 'number'))
                return false;
            x = Math.abs(x);
            y = Math.abs(y);
            while (y) {
                var t = y;
                y     = x % y;
                x     = t;
            }
            return x;
        },

        ratioSuggestion(device, gridArray, gridValueCount){

            //  A ratio can be simplified by dividing both sides of the ratio by the Highest Common Factor (HCF). I mean greatest common divisor :D

            let itemArray = gridArray.slice(0, gridArray.length);

            itemArray.push(gridValueCount);

            //console.log(itemArray);

            let common = this.gcd(itemArray);
            if (common > 1) {

                itemArray.pop();

                let simplifiedRatio = gridValueCount / common;

                let simplifiedGrid = itemArray.map((i) => (i / common) + ":" + simplifiedRatio);

                device.ratioSuggestionMsg = sprintf(this.grid.simplifiedRatio, simplifiedGrid.join(' + '));

                device.ratioSuggestion = true;
            }
        },

        openManualInput(deviceId){
            this.showManualInput[deviceId] = !this.showManualInput[deviceId];
        },

        columnLayouts(device){
            return this.model._upb_options.tools[device.id];
        },

        deviceClass(device){
            return [
                device.current ? 'current selected' : '',
                device.active ? 'active' : 'inactive',
                device.reconfig ? 're-config-column' : ''
            ].join(' ')
        },

        setSelectedColumnLayout(){

            //console.log(this.model.contents);

            this.devices.map((device) => {

                Vue.set(this.selectedColumnLayout, device.id, '');
                Vue.set(this.showManualInput, device.id, false);
                Vue.set(this.manualLayout, device.id, false);

                let selected = this.model.contents.map((column) => {

                    if (column.attributes[device.id].trim()) {
                        return column.attributes[device.id].trim();
                    }
                    return false;
                });

                Vue.set(this.selectedColumnLayout, device.id, _.compact(selected).join(' + '));

                this.isManualLayout(device);
            });
        },

        changeColumnLayout(layout, deviceId){
            this.selectedColumnLayout[deviceId] = layout.value.trim();

        },

        miniColumns(columns){
            return columns.split('+').map((i) => i.trim());
        },

        miniColumnItem(item){
            return item.split(':')[0].trim();
        },

        miniColumnItemClass(item){
            let i = item.split(':')[0].trim();
            return `grid-item-${i}`;
        },

        columnLayoutClass(layout, deviceId){
            return [
                (layout.value == this.selectedColumnLayout[deviceId]) ? 'active' : '',
                layout.class
            ].join(' ');
        },

        manualLayoutClass(deviceId){
            return [
                (this.manualLayout[deviceId]) ? 'active' : '',
                'manual'
            ].join(' ');
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
            return `${id}-list`;
        },

        deleteItem(start, end = 1){
            this.model.contents.splice(start, end);
            store.stateChanged();
        },

        cloneItem(index, item){
            let cloned              = extend(true, {}, item);
            cloned.attributes.title = `Clone of ${cloned.attributes.title}`;
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

                this.updateColumnOrder();
                // console.log(this.model.contents);
            });

            // store.stateChanged();
        },

        updateColumnOrder(){

            let sorted = [];

            this.devices.map((device)=> {

                let value = [];
                this.model.contents.map((content)=> {

                    if (content.attributes[device.id].trim()) {
                        value.push(content.attributes[device.id]);
                    }

                });

                sorted.push({id : device.id, grid : value})

            });

            sorted.map((device)=> {

                if (device.grid.length > 0) {
                    this.selectedColumnLayout[device.id] = device.grid.join(' + ').trim()
                }

            })

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

        toolsAction(tool, event = false){

            let data = tool.data ? tool.data : false;

            if (!this[tool.action]) {
                util.warn(`You need to implement '${tool.action}' method.`, this);
            }
            else {
                this[tool.action](data, event);
            }
        },

        cleanup(content) {
            this.devices.map((d)=> {
                content.attributes[d.id] = '';
            });
            return content;
        },

        addNew(content, event = false){

            // Only For Column cleanup

            let data = extend(true, {}, this.cleanup(content));

            if (data.attributes.title) {
                data.attributes.title = sprintf(data.attributes.title, (this.model.contents.length + 1));
            }
            this.model.contents.push(data);

            store.stateChanged();
        }
    }
}

