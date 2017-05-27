<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <p class="upb-input-heading" v-html="title"></p>
        </div>
    </li>
</template>
<script>
    import store from '../../store'
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name     : 'upb-input-heading',
        mixins   : [common, userInputMixin('heading')],
        computed : {
            title(){
                return store.wpKsesPost(this.attributes.title);
            }
        }
    }
</script>