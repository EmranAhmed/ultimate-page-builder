<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attrs.title"></span>

                <select v-model="model.metaValue" :id="attrs._id">
                    <option v-for="(option, value) in attrs.options" :value="value" v-text="option"></option>
                </select>

            </label>

            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-select',
        props  : ['index', 'attrs', 'model'],
        mixins : [common],
    }
</script>