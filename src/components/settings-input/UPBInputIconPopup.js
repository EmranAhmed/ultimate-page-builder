import extend from 'extend'
import {sprintf} from 'sprintf-js';
import common from './common'
import userInputMixin from './user-mixins'

import UPBMediaIconPopup from '../extra/UPBMediaIconPopup.vue';

Vue.component('upb-media-icon-popup', UPBMediaIconPopup);

export default {
    name : 'upb-input-icon-popup',

    mixins : [common, userInputMixin('icon-popup')],

    data(){
        return {
            show      : false,
            providers : [
                {
                    id    : 'fontawesome',
                    title : 'Font Awesome'
                },
                {
                    id    : 'materialdesign',
                    title : 'Material Design'
                },
                {
                    id    : 'dashicon',
                    title : 'DashIcons'
                }
            ],
        }
    },

    computed : {},

    methods : {
        iconSelected(e){
            console.log(e);
        },

        closePopup(){
            this.show = false;
        },
        openPopup(){
            this.show = true;
        }
    }
}