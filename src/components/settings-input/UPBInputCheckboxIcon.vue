<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="device-hidden-input">
                <label v-for="(option, value) in attributes.options">
                    <input class="device-hidden-input" type="checkbox" :value="value" v-model="input">
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
        name   : 'upb-input-checkbox-icon',
        mixins : [common, userInputMixin('checkbox-icon')]
    }
</script>