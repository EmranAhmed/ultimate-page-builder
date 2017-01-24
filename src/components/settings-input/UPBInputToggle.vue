<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group toggle">
            <span class="title" v-text="attributes.title"></span>
            <label class="switch toggle-input-group">
                <input class="toggle-input" v-model="input" type="checkbox" :id="attributes._id">
                <div class="slider round"></div>
            </label>
            <div class="clear"></div>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<style lang="sass" src="./UPBInputToggle.scss"></style>
<script>
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name   : 'upb-input-toggle',
        mixins : [common, userInputMixin('toggle')],
    }
</script>