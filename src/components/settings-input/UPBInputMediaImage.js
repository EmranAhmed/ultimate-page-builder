import Vue from "vue";
import store from "../../store";
import common from "./common";
import userInputMixin from "./user-mixins";

import UPBMedia from "../../plugins/vue-upb-media";

Vue.use(UPBMedia)

export default {
    name : 'upb-input-media-image',

    mixins : [common, userInputMixin('media-image')],

    data() {
        return {
            id   : '',
            size : '',
            src  : ''
        }
    },

    created() {
        this.parseImageData()
    },

    methods : {
        parseImageData() {
            if (this.input) {
                let [id, size, src] = this.input.split('|')
                if (!src) {
                    this.src = id;
                }
                else {
                    this.id   = id;
                    this.size = size;
                    this.src  = src;
                }
            }
        },
        combineImageData(attachment) {
            this.id    = attachment.id;
            this.size  = attachment.size;
            this.src   = attachment.url;
            this.input = [this.id, this.size, this.src].join('|');
        },

        onInsert(e, attachment) {
            this.combineImageData(attachment)
        },
        onRemove(e) {
            this.input = '';
            this.id    = '';
            this.size  = '';
            this.src   = '';
        }
    }
}