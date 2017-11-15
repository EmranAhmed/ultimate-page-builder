<template>
    <li :class="typeClass()" v-show="isRequired">
        <div :class="currentDevice">
            <div class="title-wrapper">
                <span class="title" v-text="attributes.title"></span>
            </div>
            <div class="device-hidden-input">
                <label v-for="(option, value) in attributes.options" :key="value">
                    <input class="device-hidden-input" type="radio" :value="value" v-model="input">
                    <i :class="option.icon" :title="option.title"></i>
                </label>
            </div>
        </div>
    </li>
</template>
<script>
    import common from './common'

    export default {
        name   : 'upb-input-media-query-radio-tab',
        mixins : [common],
        computed : {
            currentDevice(){
                 this.setValue(this.store.currentPreviewDevice);
                 return [this.store.currentPreviewDevice, 'form-group'].join(' ');
            },
        },
        methods : {
            setValue(value){

                Vue.set(this.attributes, 'value', value);
                Vue.set(this.model, this.target, value);

                // store.stateChanged();

                if (this.attributes['reload']) {
                    // store.reloadPreview()
                }
            }
        }
    }
</script>