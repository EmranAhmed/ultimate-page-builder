import store from '../../store'
import common from './common'
import userInputMixin from './user-mixins'

import  '../../plugins/vue-upb-media'
import '../../plugins/vue-background-position'

export default {
    name : 'upb-input-background-image',

    mixins : [common, userInputMixin('background-image')],

    methods : {
        onInsert(e, id, src){
            Vue.set(this, 'input', src);
        },
        onRemove(e){
            Vue.set(this, 'input', '');
        },

        pointerMovedTo(position){
            if (this.attributes.use) {
                this.setValueOf(this.attributes.use, position);
            }
        }
    }
}