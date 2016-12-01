<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attrs.title"></span>
                <input v-model="model[attrs.id]" class="form-control" :id="attrs._id" :placeholder="attrs.placeholder">
            </label>

            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-text',
        props  : ['index', 'attrs', 'model'],
        mixins : [common],
    }
</script>