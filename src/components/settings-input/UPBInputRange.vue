<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>

                <div class="range-input-group">
                    <span class="prefix" v-text="attributes.options.prefix"></span>
                    <input class="range-input" v-model="input" type="range" :min="attributes.options.min" :max="attributes.options.max" :step="attributes.options.step">
                    <input class="number-input" v-model="input" :placeholder="attributes.placeholder" type="number" :min="attributes.options.min" :max="attributes.options.max" :step="attributes.options.step">
                    <span class="suffix" v-text="attributes.options.suffix"></span>
                </div>

            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-range',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
        created(){
            //   console.log(this.model, this.index, this.target, this.attributes)
        }
    }
</script>