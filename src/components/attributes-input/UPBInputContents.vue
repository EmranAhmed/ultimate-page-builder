<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attrs.title"></span>
                <textarea v-model="item.contents" class="form-control" :id="attrs._id" :placeholder="attrs.placeholder"></textarea>
            </label>

            <p class="description" v-if="attrs.desc" v-html="attrs.desc"></p>
        </div>
    </li>
</template>
<script>

    import common from './common'

    export default {
        name   : 'upb-input-contents',
        props  : ['index', 'attrs', 'model', 'item'],
        mixins : [common],
        created(){
            this.$watch(`item.contents`, function (value) {

                this.model[this.attrs.id] = value;
                //this.item.contents   = value;
                this.attrs.value          = value;
                this.attrs.metaValue      = value;

                store.stateChanged();

                if (this.attrs['reload']) {
                    store.reloadPreview()
                }
            }.bind(this));
        },
    }
</script>