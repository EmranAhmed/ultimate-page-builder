<template>
    <li :class="typeClass()">
        <div class="form-group">
            
            <label v-if="multiple">
                <span class="title" v-text="attributes.title"></span>
                <select multiple v-model="input" style="width: 100%" v-select2="attributes.settings" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :value="value" v-text="option"></option>
                </select>
            </label>

            <label v-else>
                <span class="title" v-text="attributes.title"></span>
                <select v-model="input" style="width: 100%" v-select2="attributes.settings" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :value="value" v-text="option"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script>

    import common from './common'

    import Select2 from '../../plugins/vue-select2'

    Vue.use(Select2);

    export default {
        name   : 'upb-input-select2',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],

        methods : {
            onChange(data, e){
                if (_.isUndefined(this.attributes['multiple'])) {
                    this.input = data.id;
                }
                else {
                    this.input.push(data.id)
                }
            },
            onRemove(data){
                if (!_.isUndefined(this.attributes['multiple'])) {
                    Vue.set(this, 'input', _.without(this.input, data.id));
                }
            }
        }
    }
</script>