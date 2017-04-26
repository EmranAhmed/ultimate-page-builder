<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="device-hidden-input">
                <div v-for="(option, i) in options" :key="i">
                    <label v-for="device in option" :key="device.id">
                        <input class="device-hidden-input" :disabled="device.disabled" type="checkbox" :value="device.id" v-model="input">
                        <i :class="device.icon" :title="device.title"></i>
                        <span class="device-symbol" v-if="device.suffix && device.symbol" v-html="device.symbol"></span>
                    </label>
                </div>
            </div>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputDeviceHidden.js"></script>