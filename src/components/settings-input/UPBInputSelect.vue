<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label v-if="multiple">
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select-multiple-input" v-model="input" multiple>
                    <option v-for="(option, value) in attributes.options" :key="value" :value="value" v-text="option"></option>
                </select>
            </label>

            <label v-else>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select-input" v-model="input">
                    <option v-for="(option, value) in attributes.options" :key="value" :value="value" v-text="option"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-select',
        mixins : [common, userInputMixin('select')]
    }
</script>