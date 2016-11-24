import Vue from 'vue'

//import UPBSidebar from './UPBSidebar.vue'

import App from './App.vue'

import UPBPreview from './UPBPreview.vue'
import store from './store'

import VueNProgress from './plugins/vue-nprogress'

Vue.use(VueNProgress);

//const states = window._upb_states;

//const status = window._upb_status;

// window.upbBuilder

import router from './router'


const upbBuilder = new Vue({
    router,
    el   : '#upb-sidebar',
    data : {
        store
    },

    mounted() {
        this.$nextTick(function () {
            document.getElementById('upb-pre-loader').classList.add('loaded');
        })
    },

    //render : h => h(UPBSidebar)
    render : h => h(App)
});

const upbPreview = new Vue({
    data   : {
        store
    },
    render : h => h(UPBPreview)
});

window.frames['upb-preview-frame'].window.onload = () => {
    //upbPreview.$mount(window.frames['upb-preview-frame'].window.document.getElementById('upb-preview'))
    upbPreview.$mount(window.frames['upb-preview-frame'].contentWindow.document.getElementById('upb-preview'))
}



