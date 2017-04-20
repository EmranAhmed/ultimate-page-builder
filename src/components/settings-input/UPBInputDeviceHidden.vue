<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="device-hidden-input">

                <div v-for="(symbol, suffix) in attributes.suffix">
                    <label v-for="device in attributes.options">
                        <input class="device-hidden-input" :disabled="device.disabled" type="checkbox" :value="`${device.id}${suffix}`" v-model="input">
                        <i :class="device.icon" :title="device.title"></i>
                        <span class="device-symbol" v-if="suffix && symbol" v-html="symbol"></span>
                    </label>
                </div>
            </div>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputDeviceHidden.js"></script>