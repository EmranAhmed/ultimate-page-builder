<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <!-- .info, .success, .warning, .error -->
            <p :class="messageClass()" v-html="title"></p>
        </div>
    </li>
</template>
<script>
    import store from '../../store'
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name     : 'upb-input-message',
        mixins   : [common, userInputMixin('message')],
        computed : {
            title(){
                return store.wpKsesPost(this.attributes.title);
            }
        },
        methods  : {
            messageClass(){
                return `upb-input-message ${this.attributes.style}`;
            }
        }
    }
</script>