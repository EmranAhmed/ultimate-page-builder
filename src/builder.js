import Vue from 'vue'
import store from './store'
import router from './router'

import UPBSidebar from './UPBSidebar.vue'
import UPBPreview from './UPBPreview.vue'

import VueNProgress from './plugins/vue-nprogress'

Vue.use(VueNProgress);

import vToast from './plugins/vue-toastr'
Vue.use(vToast);

//const states = window._upb_states;

store.loadTabContents();

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

    render : createElement => createElement(UPBSidebar)
});

function loadPreview() {

    let settings = {};

    store.tabs.filter(function (content) {
        return content.id == 'settings' ? content : false;
    }).pop().contents.map(function (data) {
        if (data.metaId == 'enable' || data.metaId == 'position') {
            settings[data.metaId] = data.metaValue;
        }
    });

    store.panel = upbBuilder

    if (settings.enable) {
        new Vue({
            //router,
            data   : {
                store
            },
            render : createElement => createElement(UPBPreview)
        })
        //.$mount(window.frames['upb-preview-frame'].contentWindow.document.getElementById('upb-preview'))
            .$mount(window.frames['upb-preview-frame'].contentWindow.document.getElementById(settings.position))

    }
}

window.onload = _=> {
    //console.log('Sidebar loaded');
    loadPreview();
}

document.getElementById("upb-preview-frame").addEventListener('load', _=> {

    //console.log('preview loaded');
    loadPreview();
});
