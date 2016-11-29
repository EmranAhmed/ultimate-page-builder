<template>
    <li :class="typeClass()">


        <div class="form-group toggle">
            <span class="title" v-text="attrs.title"></span>
            <label class="switch">
                <input type="checkbox" :id="attrs._id" v-model="model[attrs.id]">
                <div class="slider round"></div>
            </label>
            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>
<style lang="sass" src="./UPBInputToggle.scss"></style>
<script>
    import common from './common'

    export default {
        name   : 'upb-input-toggle',
        props  : ['index', 'attrs', 'model'],
        mixins : [common]
    }
</script>