import common from './common'
import userInputMixin from './user-mixins'
export default {
    name   : 'upb-input-device-hidden',
    mixins : [common, userInputMixin('device-hidden')],

    watch : {
        input(value){
            this.disabled();
        }
    },

    methods : {

        disabled(){
            this.attributes.options.map((option)=> {
                option.disabled = false;
                this.input.map((selected)=> {
                    if (this.attributes.disable[selected]) {
                        let disable     = this.attributes.disable[selected];
                        option.disabled = disable.includes(option.id);
                    }
                });
            });
        }
    }
}