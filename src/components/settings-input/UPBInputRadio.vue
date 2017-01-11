<template>
    <li :class="typeClass()" v-show="isRequired">

        <div class="form-group">
            <span class="title" v-text="attributes.title"></span>

            <div v-for="(option, value) in attributes.options">
                <input class="radio-input" type="radio" :id="value" :value="value" v-model="input">
                <label :for="value" v-text="option"></label>
            </div>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>

    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-radio',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
    }
</script>