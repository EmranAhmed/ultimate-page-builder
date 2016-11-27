<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label :for="attrs.id" v-text="attrs.title"></label>
            <input v-model="model[attrs._id]" class="form-control" :id="attrs.id" :placeholder="attrs.placeholder">
            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>
<script>
    export default {
        name    : 'upb-input-text',
        props   : ['index', 'attrs', 'model'],
        methods : {
            typeClass(){
                return `${this.attrs.type}-field-wrapper`;
            }
        }
    }
</script>