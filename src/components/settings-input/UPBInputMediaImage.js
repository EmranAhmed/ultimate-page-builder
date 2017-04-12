import store from '../../store'
import common from './common'
import userInputMixin from './user-mixins'

import ImageMedia from '../../plugins/vue-image-media'

Vue.use(ImageMedia)

export default {
    name : 'upb-input-media-image',

    mixins : [common, userInputMixin('media-image')],

    data(){
        return {
            src : ''
        }
    },

    created(){

        if (this.input && this.attributes.attribute == 'id') {

            store.wpAjax(
                'get-attachment', // see /wp-admin/admin-ajax.php, will converted to wp_ajax_get_attachment
                {
                    id : this.input,
                },
                image => {
                    if (_.isUndefined(image.sizes)) {
                        this.src = image.url;
                    }
                    else {
                        this.src = image.sizes[this.attributes.size].url;
                    }
                },
                error => {
                    console.info(`Image Not Found by ID# ${this.input}`, error)
                }
            );
        }
        else {
            this.src = this.input;
        }
    },

    methods : {
        onSelect(e, id, src){

            if (this.attributes.attribute == 'id') {
                this.input = id;
            }
            else {
                this.input = src;
            }
            this.src = src;
        },
        onRemove(e){
            this.input = '';
            this.src   = '';
        }
    }
}