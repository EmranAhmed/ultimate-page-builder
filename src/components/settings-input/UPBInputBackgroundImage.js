import Vue from "vue";
import common from "./common";
import userInputMixin from "./user-mixins";

import UPBMedia from "../../plugins/vue-upb-media";

Vue.use(UPBMedia);

import BackgroundPosition from "../../plugins/vue-background-position";

Vue.use(BackgroundPosition);

export default {
    name : 'upb-input-background-image',

    mixins : [common, userInputMixin('background-image')],

    methods : {
        onInsert(e, attachment) {
            Vue.set(this, 'input', attachment.url);
        },
        onRemove(e) {
            Vue.set(this, 'input', '');
        },

        pointerMovedTo(position) {
            if (this.attributes.use) {
                this.setValueOf(this.attributes.use, position);
            }
        }
    }
}