<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <textarea class="textarea-input" v-model="input" :wrap="attributes.options.wrap" :rows="attributes.options.rows" :placeholder="attributes.placeholder"></textarea>
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-textarea',
        mixins : [common, userInputMixin('textarea')],
    }
</script>