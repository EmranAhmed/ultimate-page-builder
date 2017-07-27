import store from "../../store";

export default {
    name  : 'upb-sidebar-sub-panel',
    props : ['index', 'model', 'panel'],
    data(){
        return {
            l10n            : store.l10n,
            devices         : store.devices,
            sidebarExpand   : true,
            skeletonPreview : false
        }
    },

    computed : {
        subPanelClass(){
            return [`sub-panel-wrapper`, `sub-panel-${this.panel}-opened`].join(' ');
        },

        subPanelComponent(){
            return `upb-sub-panel-${this.panel}`;
        }
    },

    watch : {
        panel(panelId){

            if (_.isEmpty(panelId)) {
                this.closeSubPanel();
            }
            else {
                this.openSubPanel(panelId);
            }
        }
    },

    methods : {

        openSubPanel(panel){
            document.getElementById('upb-wrapper').classList.add('show-subpanel');
        },

        closeSubPanel(){
            store.subpanel = '';
            document.getElementById('upb-wrapper').classList.remove('show-subpanel');
        }
    },

    components : {
        'upb-sub-panel-sections' : () => import(/* webpackChunkName: "upb-sub-panel-sections" */ './UPBSubPanelSections.vue')
    }
}