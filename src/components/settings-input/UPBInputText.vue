<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <input class="text-input" type="text" v-model="input" :placeholder="attributes.placeholder">
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-text',
        mixins : [common, userInputMixin('text')]
    }
</script>