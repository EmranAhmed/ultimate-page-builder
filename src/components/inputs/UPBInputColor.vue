<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attrs.title"></span>
                <input v-colorpicker type="text" :data-default-color="attrs.value" :value="attrs.value" :id="attrs.id" :placeholder="attrs.placeholder">
            </label>

            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>

<script>

    import ColorPicker from '../../plugins/vue-colorpicker'

    Vue.use(ColorPicker);

    export default {
        name    : 'upb-input-color',
        props   : ['index', 'attrs', 'model'],
        methods : {
            typeClass(){
                return `${this.attrs.type}-field-wrapper form-field-wrapper`;
            },

            onColorChange(color){
                this.attrs.value           = color;
                this.model[this.attrs._id] = color;
            }
        }
    }
</script>