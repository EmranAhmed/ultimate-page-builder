import Vue, { util } from 'vue';

import SectionsPanel from '../panels/SectionsPanel.vue'
import SettingsPanel from '../panels/SettingsPanel.vue'

export default {
    name  : 'panel-view',
    props : ['index', 'model'],

    data(){
        return {}
    },

    watch : {
        $route (to, from) {

            const toDepth       = to.path.split('/').length
            const fromDepth     = from.path.split('/').length
            this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left'

            //console.log(toDepth, fromDepth)
        }
    },
    created() {

        console.log(this.model)
        console.log(this.$route.name)
        console.log(this.$route.params)
    },

    computed : {},

    mounted(){},

    methods : {
        capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }
}
