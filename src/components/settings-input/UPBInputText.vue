<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <input type="text" v-model="input" :id="attributes._id" :placeholder="attributes.placeholder" class="form-control">
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>

        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-text',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],
        created(){
            //   console.log(this.model, this.index, this.target, this.attributes)
        }
    }
</script>