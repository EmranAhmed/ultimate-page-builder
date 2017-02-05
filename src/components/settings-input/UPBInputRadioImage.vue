<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="image-selects">
                <label v-for="(option, value) in attributes.options">
                    <input class="image-select-input" type="radio" :value="value" v-model="input">
                    <img :src="option.url" :title="option.title" :alt="option.title" draggable="false">
                </label>
                <div class="clear"></div>
            </div>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-radio-image',
        mixins : [common, userInputMixin('radio-image')]
    }
</script>