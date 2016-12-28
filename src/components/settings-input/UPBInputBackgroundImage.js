import store from '../../store'
import common from './common'

import ImageMedia from '../../plugins/vue-image-media'
import BackgroundPosition from '../../plugins/vue-background-position'

Vue.use(ImageMedia);
Vue.use(BackgroundPosition);

export default {
    name   : 'upb-input-background-image',
    // props  : ['index', 'target', 'model', 'attributes'], // model[target] v-model="input"
    mixins : [common],
    data(){
        return {
            src : ''
        }
    },

    computed : {
        positions(){

            //console.log(this.attributes.use);

            return this.getValueOf(this.attributes.use);
            //return '0% 0%';
        }
    },

    created(){
        if (this.input) {

            store.wpAjax(
                'get-attachment', // see /wp-admin/admin-ajax.php, will converted to wp_ajax_get_attachment
                {
                    id : this.input,
                },
                (image) => {
                    if (_.isUndefined(image.sizes)) {
                        this.src = image.url;
                    }
                    else {
                        this.src = image.sizes[this.attributes.size].url;
                    }
                },
                function () { console.log(`Image Not Found`) }
            );
        }
    },

    methods : {
        onSelect(e, id, src){
            this.input = src;

        },
        onRemove(e){
            this.input = null;
        },

        pointerMovedTo(position){
            this.setValueOf(this.attributes.use, position);
        }

    }
}