<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">

            <label v-if="multiple">
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select2-multiple-input" multiple v-model="input" style="width: 100%" v-select2="attributes.settings" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :key="value" :value="value" :title="option" v-text="option"></option>
                </select>
            </label>

            <label v-else>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select2-input" v-model="input" style="width: 100%" v-select2="attributes.settings" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :key="value" :value="value" :title="option" v-text="option"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script>

    import Vue from 'vue'
    import common from './common'
    import userInputMixin from './user-mixins'
    import Select2 from '../../plugins/vue-select2'

    Vue.use(Select2);

    export default {
        name    : 'upb-input-select2',
        mixins  : [common, userInputMixin('select2')],
        methods : {
            onChange(data, e){

                if (this.multiple) {
                    let id = _.isNumber(data.id) ? data.id.toString() : data.id;
                    this.input.push(id);
                }
                else {
                    Vue.set(this, 'input', data.id.toString());
                }
            },
            onRemove(data){
                if (this.multiple) {
                    let id = _.isNumber(data.id) ? data.id.toString() : data.id;
                    Vue.set(this, 'input', _.without(this.input, id));
                }
            }
        }
    }
</script>