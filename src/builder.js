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

    upbBuilderPreview : null,

    destroy(){
        if (this.upbBuilderPreview) {
            this.upbBuilderPreview.$destroy();
        }
    },

    mount(){

        store.panel = upbBuilder

        if (store.getSetting('enable')) {
            this.upbBuilderPreview = new Vue({
                data   : {
                    store
                },
                render : createElement => createElement(UPBPreview)
            }).$mount(store.previewDocument().getElementById(store.getSetting('position')));
        }
    },

    setUrl(){
        document.getElementById('upb-preview-frame').src = document.getElementById('upb-preview-frame').dataset.url;
    }
};

window.addEventListener('load', _=> {
    previewWindow.setUrl();
});

document.getElementById("upb-preview-frame").addEventListener('load', _=> {
    previewWindow.destroy();
    previewWindow.mount();
});