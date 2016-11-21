import Vue from 'vue';

// import store from '../store'

// Sections Panel

import SectionsPanel from '../panel/SectionsPanel.vue';
Vue.component('sections-panel', SectionsPanel);

// Elements Panel

// Settings Panel

// Logical Panel

export default {
    name    : 'upb-sidebar-contents',
    props   : ['index', 'model'],
    methods : {
        getPane(id){
            return `${id}-panel`;
        }
    }
}