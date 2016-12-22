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
                    // store.reloadPreview();
                    this.$progressbar.hide();
                    this.$toast.success(this.l10n.save);
                }, () => {
                    this.$progressbar.hide();
                    this.$toast.error(this.l10n.savingProblem);
                });
            }
        },

        isDirty(){
            return store.isDirty();
        }
    }
}