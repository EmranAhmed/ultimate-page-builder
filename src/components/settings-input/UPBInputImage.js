import store from '../../store'
import common from './common'

import ImageMedia from '../../plugins/vue-image-media'

Vue.use(ImageMedia)

export default {
    name   : 'upb-input-image',
    props  : ['index', 'target', 'model', 'attributes'], // model[target] v-model="input"
    mixins : [common],
    data(){
        return {
            src : ''
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

            this.input = id;
            this.src   = src;

        },
        onRemove(e){
            this.input = null;
            this.src   = null;
        }
    }
}