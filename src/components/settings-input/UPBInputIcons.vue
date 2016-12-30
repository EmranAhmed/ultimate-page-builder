<template>
    <li :class="typeClass()">
        <div class="form-group">

            <label>
                <span class="title" v-text="attributes.title"></span>
                <select class="select2-input" v-model="input" style="width: 100%" v-select2="settings" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :value="value" v-text="option"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script>

    import common from './common'
    import extend from 'extend'

    import Select2 from '../../plugins/vue-select2'

    Vue.use(Select2);

    export default {
        name   : 'upb-input-icons',
        props  : ['index', 'target', 'model', 'attributes'], // model[target]
        mixins : [common],

        computed : {
            settings(){
                let settings = extend(true, {}, this.attributes.settings);

                settings['templateResult'] = state => this.template(state);
                settings['templateSelection'] = state => this.template(state);

                return settings;
            }
        },

        methods : {

            template(state){
                if (!state.id) {
                    return state.text;
                }
                return jQuery(`<span class="select2-icon-input"><i class="${state.element.value}"></i> &nbsp; ${state.text}</span>`);
            },

            onChange(data, e){
                this.input = data.id;
            },

            onRemove(data){

                console.log('removed')

                Vue.set(this, 'input', '');
            }
        }
    }
</script>