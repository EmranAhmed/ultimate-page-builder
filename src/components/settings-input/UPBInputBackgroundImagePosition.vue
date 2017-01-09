<template>
    <li :class="typeClass()" v-if="isRequired">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <input class="text-input" type="text" v-model.lazy="input" :id="attributes._id" :placeholder="attributes.placeholder">
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>

        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-background-image-position',
        mixins : [common],
    }
</script>