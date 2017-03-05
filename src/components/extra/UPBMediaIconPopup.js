import store from '../../store';
import extend from 'extend';

export default {
    name : 'upb-media-icon-popup',

    props : {
        title     : {
            type    : String,
            default : 'Icon Popup'
        },
        providers : {
            type     : Array,
            required : true
        },

        columns : {
            type    : Number,
            default : 8
        }
    },

    data(){
        return {

            /*providers : [
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
             ],*/

            selectedIcons    : ['mdi mdi-open'],
            selectedProvider : ''
        }
    },

    computed : {
        iconProviders(){
            return this.providers.map((provider, index)=> {
                // O index is active one
                provider.active = index == 0;
                return provider;
            });
        },

        mediaFrameClass(){
            let frameClass = ['media-frame', 'mode-select', 'wp-core-ui', 'hide-router'];
            if (this.providers.length < 1) {
                frameClass.push('hide-menu');
            }
            return frameClass.join(' ');
        },

        selected(){
            return _.uniq(this.selectedIcons);
        }
    },

    created(){},

    methods : {

        isSelected(){
            return this.selected.length > 0;
        },

        onCloseEvent(){
            this.$emit('close');
        },

        onInsertEvent(){
            this.$emit('insert', this.selected);
            this.onCloseEvent();
        }
    }
}