import store from '../../store'
import common from './common'

import ImageMedia from '../../plugins/vue-image-media'
import BackgroundPosition from '../../plugins/vue-background-position'

Vue.use(ImageMedia);
Vue.use(BackgroundPosition);

export default {
    name   : 'upb-input-background-image',
    mixins : [common],

    methods : {
        onSelect(e, id, src){
            this.input = src;
        },
        onRemove(e){
            this.input = null;
        },

        pointerMovedTo(position){
            if (this.attributes.use) {
                this.setValueOf(this.attributes.use, position);
            }
        }
    }
}