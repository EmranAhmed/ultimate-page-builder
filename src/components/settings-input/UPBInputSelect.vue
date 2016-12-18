<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label v-if="multiple">
                <span class="title" v-text="attributes.title"></span>
                <select v-model="input" :id="attributes._id" multiple>
                    <option v-for="(option, value) in attributes.options" :value="value" v-text="option"></option>
                </select>
            </label>

            <label v-else>
                <span class="title" v-text="attributes.title"></span>
                <select v-model="input" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :value="value" v-text="option"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-select',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
    }
</script>