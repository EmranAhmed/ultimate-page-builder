<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="device-hidden-input">
                <label v-for="(option, value) in attributes.options" :key="value">
                    <input class="device-hidden-input" type="radio" :value="value" v-model="input">
                    <i :class="option.icon" :title="option.title"></i>
                </label>
            </div>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-radio-icon',
        mixins : [common, userInputMixin('radio-icon')]
    }
</script>