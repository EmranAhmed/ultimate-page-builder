<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <textarea v-model="input" class="form-control" :id="attributes._id" :placeholder="attributes.placeholder"></textarea>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-contents',
        props  : ['index', 'target', 'model', 'attributes', 'item'], // watch input and item.content = set :)
        mixins : [common],
        created(){

        },
    }
</script>