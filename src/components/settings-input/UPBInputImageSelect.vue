<template>
    <li :class="typeClass()">

        <div class="form-group">
            <span class="title" v-text="attributes.title"></span>

            <div class="image-select">
                <label v-for="(option, value) in attributes.options">
                    <input type="radio" :value="value" v-model="input">
                    <img :src="option.url" :title="option.label" :alt="option.label">
                </label>

                <div class="clearfix"></div>
            </div>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>

    </li>
</template>
<style lang="sass" src="./UPBInputImageSelect.scss"></style>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-image-select',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
    }
</script>