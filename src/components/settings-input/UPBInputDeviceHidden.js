import common from './common'
import extend from 'extend'
import userInputMixin from './user-mixins'
export default {
    name   : 'upb-input-device-hidden',
    mixins : [common, userInputMixin('device-hidden')],

    /*   data(){
     return {
     options : []
     }
     },*/

    computed : {
        options(){
            let newOptions        = [];
            let attributesOptions = extend(true, [], this.attributes.options);
            while (attributesOptions.length > 0) {
                newOptions.push(attributesOptions.splice(0, this.attributes.split));
            }

            return newOptions;
        }
    },

    created(){

        this.$watch(`input`, (value) => {
            this.disabled();
        }, {immediate : true});
    },

    methods : {

        disabled(){

            this.attributes.options.map((device)=> {

                device.disabled = false;

                this.input.map((selected)=> {

                    if (this.attributes.disable[selected]) {
                        let disable     = this.attributes.disable[selected];
                        // console.log('id', device.id, 'selected', selected, 'disabled', disable);
                        device.disabled = disable.includes(device.id);
                    }
                });

            })
        }
    }
}