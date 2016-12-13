import Vue from 'vue';

import store from '../../store'

import UPBSubPanelSections from './UPBSubPanelSections.vue'

Vue.component('upb-sub-panel-sections', UPBSubPanelSections);

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
    }
}