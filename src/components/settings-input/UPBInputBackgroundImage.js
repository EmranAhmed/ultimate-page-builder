import store from '../../store'
import common from './common'
import userInputMixin from './user-mixins'

import ImageMedia from '../../plugins/vue-image-media'
import BackgroundPosition from '../../plugins/vue-background-position'

Vue.use(ImageMedia);
Vue.use(BackgroundPosition);

export default {
    name : 'upb-input-background-image',

    mixins : [common, userInputMixin('background-image')],

    methods : {
        onSelect(e, id, src){
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