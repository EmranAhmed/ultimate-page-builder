import Vue, { util } from 'vue';
import store from '../../store'
import {sprintf} from 'sprintf-js'

export default {

    name : 'upb-layouts-list',

    props : ['index', 'model'],

    data(){
        return {
            l10n : store.l10n
        }
    },

    computed : {
        image(){
            return this.model.preview ? model.preview : this.l10n.layoutPlaceholder;
        }
    },

    methods : {

        useLayout(){
            let template = this.model.template.trim();
            try {

                let code = JSON.parse(template);

                // console.log(code);
                // Send Ajax and get UPB Options
                store.addUPBOptions(code, data=> {
                    if (_.isArray(data)) {
                        store.addContentsToTab('sections', data);
                        this.$toast.success(sprintf(this.l10n.layoutAdded, this.l10n.pageTitle));
                        this.$router.replace('/sections');
                    }
                }, data=> {
                    console.log(data);
                })

                //

            } catch (err) {
                // console.log('Could Not Copy', err);
                this.$toast.error('Use valid JSON Data');
            }

        }
    }
}