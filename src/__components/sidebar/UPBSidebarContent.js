//import Vue from 'vue';

// import store from '../store'

// Sections Panel

//import SectionsPanel from '../panel/SectionsPanel.vue';
//Vue.component('sections-panel', SectionsPanel);

// Elements Panel

// Settings Panel

// Logical Panel

export default {
    name    : 'upb-sidebar-contents',
    props   : ['index', 'model'],
    watch : {
        $route (to, from) {
            const toDepth       = to.path.split('/').length
            const fromDepth     = from.path.split('/').length
            this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left'

            console.log(this.$route.name);
        }
    },
    created() {

        console.log(this.model)
        console.log(this.$route.name)
    },
    methods : {
        /*getPane(id){
         return `${id}-panel`;
         }*/
    }
}