<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <p :class="messageClass()" v-text="attributes.title"></p>
        </div>
    </li>
</template>
<script>
    import common from './common'
    import userInputMixin from './user-mixins'

    export default {
        name    : 'upb-input-message',
        mixins  : [common, userInputMixin('message')],
        methods : {
            messageClass(){
                return `upb-input-message-wrapper ${this.attributes.style}`;
            }
        }
    }
</script>