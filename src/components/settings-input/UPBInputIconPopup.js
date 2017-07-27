import Vue from "vue";
import { sprintf } from "sprintf-js";
import common from "./common";
import userInputMixin from "./user-mixins";

export default {
    name : 'upb-input-icon-popup',

    mixins : [common, userInputMixin('icon-popup')],

    data(){
        return {
            show : false
        }
    },

    computed : {
        providers(){
            return this.attributes.providers
        }
    },

    methods : {
        iconSelected(selected){
            Vue.set(this, 'input', selected.id);
        },

        removeIcon(){
            Vue.set(this, 'input', '');
        },

        closePopup(){
            this.show = false;
        },
        openPopup(){
            this.show = true;
        }
    },

    components : {
        'upb-media-icon-popup' : () => import(/* webpackChunkName: "UPBMediaIconPopup" */ '../extra/UPBMediaIconPopup.vue')
    }
}