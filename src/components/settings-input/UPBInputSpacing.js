import common from './common'
import userInputMixin from './user-mixins'

export default {
    name     : 'upb-input-spacing',
    mixins   : [common, userInputMixin('spacing')],
    data(){
        return {
            property  : {
                top    : '',
                right  : '',
                bottom : '',
                left   : ''
            },
            shorthand : false,
        }
    },
    computed : {
        generatedValue(){
            return Object.keys(this.attributes.options).reduce((arr, key) => {
                arr.push(this.property[key].toString());
                return arr;
            }, []);
        }
    },

    watch : {
        'property.top'    : function (value) {

            if (this.shorthand) {
                this.updateOtherPropertyValue(value);
            }

            if (!_.isEqual(this.input, this.generatedValue)) {
                this.setValue(this.generatedValue);
            }
        },
        'property.right'  : function (value) {
            if (this.shorthand) {
                this.updateOtherPropertyValue(value);
            }

            if (!_.isEqual(this.input, this.generatedValue)) {
                this.setValue(this.generatedValue);
            }
        },
        'property.bottom' : function (value) {
            if (this.shorthand) {
                this.updateOtherPropertyValue(value);
            }

            if (!_.isEqual(this.input, this.generatedValue)) {
                this.setValue(this.generatedValue);
            }
        },
        'property.left'   : function (value) {
            if (this.shorthand) {
                this.updateOtherPropertyValue(value);
            }

            if (!_.isEqual(this.input, this.generatedValue)) {
                this.setValue(this.generatedValue);
            }
        }
    },

    created(){

        let currentValue = this.input;

        this.calculateShorthand({
            top    : currentValue[0].toString(),
            right  : currentValue[1].toString(),
            bottom : currentValue[2].toString(),
            left   : currentValue[3].toString()
        });
    },

    methods : {
        toggleShorthand(){
            this.shorthand = !this.shorthand;
        },

        calculateShorthand(currentValue){

            let usingOptions = Object.keys(this.attributes.options).filter(key=> {
                return this.attributes.options[key];
            });

            let totalOptions = usingOptions.length;

            if (totalOptions <= 1) {
                console.info(`%c Better use type 'number' instead of 'spacing' for single spacing value.`, 'color:red; font-size:18px');
            }

            let totalValues = usingOptions.reduce((total, option)=> {
                return total += parseFloat(currentValue[option]);
            }, 0);

            let checkValue = (totalValues / totalOptions);

            this.shorthand = usingOptions.every(option=> {
                let value = parseFloat(currentValue[option]);
                return value === checkValue;
            });

            Object.keys(this.attributes.options).map((option)=> {
                this.property[option] = currentValue[option].toString();
            });

            // console.log(usingOptions, currentValue, this.property, totalValues, (totalValues / totalOptions), this.shorthand)

        },

        isNumeric(value){
            return !isNaN(parseFloat(value)) && isFinite(parseFloat(value));
        },

        updateOtherPropertyValue(value){

            if (this.attributes.options['top']) {
                this.property.top = value;
            }
            if (this.attributes.options['right']) {
                this.property.right = value;
            }
            if (this.attributes.options['bottom']) {
                this.property.bottom = value;
            }
            if (this.attributes.options['left']) {
                this.property.left = value;
            }
        }
    }
}