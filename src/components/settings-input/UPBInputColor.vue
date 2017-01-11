<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <input class="color-input" v-colorpicker :data-alpha="attributes.alpha" type="text" :data-default-color="attributes.value" :value="attributes.value" :id="attributes._id" :placeholder="attributes.placeholder">
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script>

    import common from './common'

    import ColorPicker from '../../plugins/vue-colorpicker'

    Vue.use(ColorPicker);

    export default {
        name    : 'upb-input-color',
        props   : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins  : [common],
        methods : {
            onColorChange(color){
                this.input = color;
                //this.attributes.value   = color;
            }
        }
    }
</script>