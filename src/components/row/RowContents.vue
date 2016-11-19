<template>
    <ul class="row-contents-layout">

        <li class="row-grid-title" v-text="layoutOfTitle"></li>


        <li class="row-grid-screen-sizes-title" v-text="grid.deviceSizeTitle"></li>

        <li class="row-grid-screen-sizes">
            <ul>
                <li v-for="device in devices" :class="{current:device.current}" @click.prevent="currentDevice(device)" :title="device.title">
                    <i :class="device.icon"></i>
                    <div @click.prevent="toggleDevice(device)" :class="{'active-device':device.active, 'device-acitivity':true}">
                        <span class="active" v-if="device.active">&check;</span>
                        <span class="inactive" v-else>&times;</span>
                    </div>
                </li>
            </ul>
        </li>


        <li class="row-grid-layouts-wrapper">


            <ul>
                <li v-for="device in devices" v-show="device.current" :class="[{'active-device':device.active, current:device.current}]" :title="device.title">


                    <ul>

                        <li class="row-grid-structure-title" v-text="l10n.column_layout + ' - ' + device.title"></li>

                        <li class="row-grid-structure-wrapper">

                            <a v-for="layout in columnLayouts(device)" :title="layout.value" @click.prevent="changeColumnLayout(layout, device.id)" :class="columnLayoutClass(layout, device.id)" href="#">
                                <span v-for="item in miniColumns(layout.value)" :class="miniColumnItemClass(item)"></span>
                            </a>

                            <a class="manual" :title="l10n.column_manual" @click.prevent="openManualInput(device.id)" href="#">
                                <span class="manual" v-text="l10n.column_manual"></span>
                            </a>

                        </li>

                        <li v-show="showManualInput[device.id]" class="row-grid-column">
                            <div class="row-grid-column-input">
                                <input v-model.lazy="selectedColumnLayout[device.id]" type="text">
                                <!--
                                                                <div v-if="showRatioSuggestion" class="suggestionMessage" v-text="ratioSuggestionMessage"></div>
                                -->
                            </div>
                        </li>

                        <li class="row-grid-order-title" v-text="l10n.column_order + ' - ' + device.title"></li>


                    </ul>


                </li>
            </ul>
        </li>


        <!--<li>{{ model._upb_options.tools }}</li>-->
        <li></li>

    </ul>
</template>
<style lang="sass"></style>
<script src="./RowContents.js"></script>
