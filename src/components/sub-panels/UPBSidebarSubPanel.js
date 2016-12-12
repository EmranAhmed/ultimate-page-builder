import store from '../../store'

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
    }
}