<template>
    <li class="typeClass()">
        <div class="form-group">
            <label>

                {{ model[target] }}
                <span class="title" v-text="attributes.title"></span>


                <input v-model="model[target]" class="form-control">

            </label>

<!--
            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
-->
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-text',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        //mixins : [common],
        created(){
            console.log(this.model, this.index, this.target, this.attributes)
        }
    }
</script>