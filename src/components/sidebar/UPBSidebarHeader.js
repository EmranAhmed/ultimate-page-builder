import Vue from 'vue';
import store from '../../store';

import UPBSidebarHeaderItem from './UPBSidebarHeaderItem.vue';

Vue.component('upb-sidebar-header-item', UPBSidebarHeaderItem);

export default {
    name  : 'upb-sidebar-header',
    props : ['index', 'model'],

    data(){
        return {
            l10n : store.l10n
        }
    },

    methods : {

        removeActive(){
            this.model.map((item) => {
                item.active = false
            });
        },

        save(){
            if (store.isDirty()) {


                this.$progressbar.show();
                store.saveState(() => {
                    store.stateSaved();
                    store.reloadPreview();
                    this.$progressbar.hide();
                }, () => {


                    ///////
                    //store.stateSaved();

                    //store.reloadPreview();
                    this.$progressbar.hide();
                });
            }
        },

        isDirty(){
            return store.isDirty();
        }
    }
}