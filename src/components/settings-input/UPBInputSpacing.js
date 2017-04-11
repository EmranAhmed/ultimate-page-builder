import common from './common'
import userInputMixin from './user-mixins'

export default {
    name     : 'upb-input-spacing',
    mixins   : [common, userInputMixin('spacing')],
    data(){
        return {

            options : {},

            property : {
                top    : '',
                right  : '',
                bottom : '',
                left   : ''
            },

            values : {
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

            let currentValue = this.input;

            return Object.keys(this.attributes.options).reduce((arr, cValue, cIndex) => {
                let value = parseFloat(this.property[cValue].toString());
                let val   = isNaN(value) ? currentValue[cIndex] : `${value}${this.attributes.unit}`;
                arr.push(val);
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

        this.options = {
            top    : this.attributes.options['top'],
            right  : this.attributes.options['right'],
            bottom : this.attributes.options['bottom'],
            left   : this.attributes.options['left']
        };

        this.calculateShorthand({
            top    : isNaN(parseFloat(currentValue[0].toString())) ? '' : parseFloat(currentValue[0].toString()),
            right  : isNaN(parseFloat(currentValue[1].toString())) ? '' : parseFloat(currentValue[1].toString()),
            bottom : isNaN(parseFloat(currentValue[2].toString())) ? '' : parseFloat(currentValue[2].toString()),
            left   : isNaN(parseFloat(currentValue[3].toString())) ? '' : parseFloat(currentValue[3].toString()),
        });
    },

    methods : {
        toggleShorthand(){
            this.shorthand = !this.shorthand;
        },

        calculateShorthand(currentValue){

            let usingOptions = Object.keys(this.options).filter(key=> {
                return this.options[key];
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

            Object.keys(this.options).map((option)=> {
                this.property[option] = currentValue[option].toString();
            });

            // console.log(usingOptions, currentValue, this.property, totalValues, (totalValues / totalOptions), this.shorthand)
        },

        isNumeric(value){
            return !isNaN(parseFloat(value)) && isFinite(parseFloat(value));
        },

        updateOtherPropertyValue(value){

            let currentValue = this.input;

            if (this.options['top']) {
                this.property.top = value;
                this.values.top   = `${value}${this.attributes.unit}`;
            }
            else {
                this.values.top = currentValue[0].toString();
            }

            if (this.options['right']) {
                this.property.right = value;
                this.values.right   = `${value}${this.attributes.unit}`;
            }
            else {
                this.values.right = currentValue[1].toString();
            }

            if (this.options['bottom']) {
                this.property.bottom = value;
                this.values.bottom   = `${value}${this.attributes.unit}`;
            }
            else {
                this.values.bottom = currentValue[2].toString();
            }

            if (this.options['left']) {
                this.property.left = value;
                this.values.left   = `${value}${this.attributes.unit}`;
            }
            else {
                this.values.left = currentValue[3].toString();
            }
        }
    }
}