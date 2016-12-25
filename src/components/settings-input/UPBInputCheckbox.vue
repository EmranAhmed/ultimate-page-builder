<template>
    <li :class="typeClass()">
        <div class="form-group">


            <span class="title" v-text="attributes.title"></span>
            <label v-for="(label, value) in attributes.options">
                <input type="checkbox" :value="value" v-model="input">
                <span v-text="label"></span>
            </label>


            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-checkbox',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
    }
</script>