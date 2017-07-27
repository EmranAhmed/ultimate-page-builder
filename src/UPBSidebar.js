import Vue from "vue";
import VueNProgress from "./plugins/vue-nprogress";
import Toast from "./plugins/vue-toastr";
import Sortable from "./plugins/vue-sortable";
Vue.component('upb-breadcrumb', () => import(/* webpackChunkName: "upb-breadcrumb" */ './components/extra/UPBBreadcrumb.vue'));

Vue.use(VueNProgress);

Vue.use(Toast);

Vue.use(Sortable);

export default {
    name       : 'upb-sidebar',
    data(){
        return this.$root.$data
    },
    components : {
        'upb-sidebar-header'    : () => import(/* webpackChunkName: "upb-sidebar-header" */ './components/sidebar/UPBSidebarHeader.vue'),
        'upb-sidebar-content'   : () => import(/* webpackChunkName: "upb-sidebar-content" */ './components/sidebar/UPBSidebarContent.vue'),
        'upb-sidebar-footer'    : () => import(/* webpackChunkName: "upb-sidebar-footer" */ './components/sidebar/UPBSidebarFooter.vue'),
        'upb-sidebar-sub-panel' : () => import(/* webpackChunkName: "upb-sidebar-sub-panel" */ './components/sub-panels/UPBSidebarSubPanel.vue')
    }
}