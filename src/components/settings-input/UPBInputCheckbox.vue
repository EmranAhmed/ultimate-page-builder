<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <span class="title" v-text="attributes.title"></span>
            <label v-for="(label, value) in attributes.options">
                <input class="checkbox-input" type="checkbox" :value="value" v-model="input">
                <span v-text="label"></span>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-checkbox',
        mixins : [common, userInputMixin('checkbox')]
    }
</script>