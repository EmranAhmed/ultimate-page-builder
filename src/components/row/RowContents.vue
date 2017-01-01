<template>
    <ul class="row-contents-layout">

        <li class="row-grid-title" v-text="layoutOfTitle"></li>

        <li class="row-grid-screen-sizes-title" v-text="grid.deviceSizeTitle"></li>

        <li class="row-grid-screen-sizes">
            <ul>
                <li v-for="device in devices" :class="deviceClass(device)" @click.prevent="currentDevice(device)" :title="deviceTitle(device)">
                    <i :class="device.icon"></i>
                    <span v-show="device.reconfig" class="re-config-icon">&excl;</span>
                    <div :title="toggleDeviceTitle(device)" @click.prevent="toggleDevice(device)" class="device-activity">
                        <span class="active" v-if="device.active">&check;</span>
                        <span class="inactive" v-else>&times;</span>
                    </div>
                </li>
            </ul>
        </li>


        <li class="row-grid-layouts-wrapper">
            <ul>
                <li v-for="device in devices" v-if="device.current" :class="[{'active-device':device.active, current:device.current}]" :title="device.title">

                    <ul>
                        <li class="row-grid-structure-title" v-text="l10n.columnLayout + ' - ' + device.title"></li>

                        <li class="reconfig-message" v-if="device.reconfig" v-text="toggleDeviceTitle(device)"></li>

                        <li class="row-grid-structure-wrapper">

                            <a v-for="layout in columnLayouts(device)" :title="layout.value" @click.prevent="changeColumnLayout(layout, device.id)" :class="columnLayoutClass(layout, device.id)" href="#">
                                <span v-for="item in miniColumns(layout.value)" :class="miniColumnItemClass(item)"></span>
                            </a>

                            <a :class="manualLayoutClass(device.id)" :title="l10n.columnManual" @click.prevent="openManualInput(device.id)" href="#">
                                <span class="manual" v-text="l10n.columnManual"></span>
                            </a>

                        </li>

                        <li v-show="showManualInput[device.id]" class="row-grid-column">
                            <div class="row-grid-column-input">
                                <div v-if="device.ratioSuggestion" class="ratio-suggestion-message" v-text="device.ratioSuggestionMsg"></div>

                                <input v-model.lazy="selectedColumnLayout[device.id]" type="text">
                            </div>
                        </li>

                        <li class="row-grid-order-title" v-if="device.active" v-text="l10n.columnOrder + ' - ' + device.title"></li>

                        <li class="row-grid-order-wrapper">
                            <ul class="row-grid-order upb-mini-row" v-sortable="sortable">
                                <li v-for="(content, index) in contents" @click="openColumnContents(index)" @mouseover="activeFocus(index)" @mouseout="removeFocus(index)" v-if="device.active" :class="sortOrderClass(index, content, device)">
                                    <div :title="l10n.columnTitle" v-text="columnLayoutTitle(content, device)"></div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>


        <!--<li>{{ model._upb_options.tools }}</li>-->
        <li></li>

    </ul>
</template>
<script src="./RowContents.js"></script>
