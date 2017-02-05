<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <div class="number-input-group">
                    <span class="prefix" v-text="attributes.options.prefix"></span>
                    <input class="number-input" v-model="input" :placeholder="attributes.placeholder" type="number" :min="attributes.options.min" :max="attributes.options.max" :size="attributes.options.size" :step="attributes.options.step">
                    <span class="suffix" v-text="attributes.options.suffix"></span>
                </div>
            </label>
            <div class="clear"></div>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-number',
        mixins : [common, userInputMixin('number')]
    }
</script>