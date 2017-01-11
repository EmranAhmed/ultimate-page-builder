<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group toggle">
            <span class="title" v-text="attributes.title"></span>
            <label class="switch">
                <input class="toggle-input" v-model="input" type="checkbox" :id="attributes._id">
                <div class="slider round"></div>
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<style lang="sass" src="./UPBInputToggle.scss"></style>
<script>
    import common from './common'

    export default {
        name   : 'upb-input-toggle',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common]
    }
</script>