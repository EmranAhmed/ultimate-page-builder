<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attrs.title"></span>
                <input v-colorpicker :data-alpha="attrs.alpha" type="text" :data-default-color="attrs.value" :value="attrs.value" :id="attrs._id" :placeholder="attrs.placeholder">
            </label>

            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>

<script>

    import common from './common'

    import ColorPicker from '../../plugins/vue-colorpicker'

    Vue.use(ColorPicker);

    export default {
        name    : 'upb-input-color',
        props   : ['index', 'attrs', 'model'],
        mixins  : [common],
        methods : {
            onColorChange(color){
                this.model[this.attrs.id] = color;
            }
        }
    }
</script>