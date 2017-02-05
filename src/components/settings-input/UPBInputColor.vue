<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <input class="color-input" v-colorpicker :data-alpha="attributes.alpha" type="text" :data-default-color="attributes.value" :value="attributes.value" :placeholder="attributes.placeholder">
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script>

    import common from './common'
    import ColorPicker from '../../plugins/vue-colorpicker'
    import userInputMixin from './user-mixins'

    Vue.use(ColorPicker);

    export default {
        name    : 'upb-input-color',
        mixins  : [common, userInputMixin('color')],
        methods : {
            onColorChange(color){
                Vue.set(this, 'input', color.toString());
            }
        }
    }
</script>