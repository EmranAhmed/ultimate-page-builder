<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <textarea class="textarea-input" v-model="input" :id="attributes._id" :placeholder="attributes.placeholder"></textarea>
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-textarea',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
        created(){
            //   console.log(this.model, this.index, this.target, this.attributes)
        }
    }
</script>