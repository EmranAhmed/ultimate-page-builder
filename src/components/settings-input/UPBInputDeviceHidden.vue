<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="device-hidden-input">
                <label v-for="device in attributes.options">
                    <input class="device-hidden-input" type="checkbox" :value="device.id" v-model="input">
                    <i :class="device.icon" :title="device.title"></i>
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
        name   : 'upb-input-device-hidden',
        mixins : [common, userInputMixin('device-hidden')]
    }
</script>