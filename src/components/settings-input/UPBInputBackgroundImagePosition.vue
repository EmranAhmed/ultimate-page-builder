<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>


                {{ bg }}

                <span class="title" v-text="attributes.title"></span>
                <!--
                                <input class="text-input" type="text" v-model="input" :id="attributes._id" :placeholder="attributes.placeholder">
                -->
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>

        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name     : 'upb-input-background-image-position',
        // props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins   : [common],
        computed : {
            bg(){
                return this.getValueOf(this.attributes.use)
            }
        },
        created(){

        }
    }
</script>