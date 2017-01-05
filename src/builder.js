import Vue from 'vue'
import store from './store'
import router from './router'
import UPBSidebar from './UPBSidebar.vue'
import UPBPreview from './UPBPreview.vue'
import VueNProgress from './plugins/vue-nprogress'

Vue.use(VueNProgress);

import vToast from './plugins/vue-toastr'
Vue.use(vToast);

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

const previewWindow = {

    mount(){
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
            }).$mount(store.previewDocument().getElementById(settings.position))
        }
    },

    setUrl(){
        document.getElementById('upb-preview-frame').src = document.getElementById('upb-preview-frame').dataset.url;
    },

    addBlankTarget(){

        let elements = store.previewDocument().querySelectorAll('a, form');

        Array.from(elements, element=> {
            element.setAttribute('target', '_blank');
        })
    }
};

window.addEventListener('load', _=> {
    //console.log('Sidebar loaded');
    previewWindow.setUrl();
});

document.getElementById("upb-preview-frame").addEventListener('load', _=> {
    //console.log('Preview loaded');
    previewWindow.addBlankTarget();
    previewWindow.mount();
});