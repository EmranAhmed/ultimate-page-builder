import store from '../../store'

export default {
    name  : 'upb-sidebar-footer',
    props : ['index', 'model'],
    data(){
        return {
            l10n            : store.l10n,
            devices         : store.devices,
            sidebarExpand   : true,
            skeletonPreview : false
        }
    },

    computed : {
        devicePreview(){
            return this.devices.map((device) => {
                if (device.active) {
                    return device.id
                }
            }).join('');
        }
    },

    methods : {

        currentDevice(device){
            return this.devicePreview == device;
        },

        collapseSidebar(){
            this.sidebarExpand = false;
            store.subpanel     = '';
            document.getElementById('upb-wrapper').classList.remove('expanded');
            document.getElementById('upb-wrapper').classList.add('collapsed');
        },

        expandSidebar(){
            this.sidebarExpand = true;
            document.getElementById('upb-wrapper').classList.remove('collapsed');
            document.getElementById('upb-wrapper').classList.add('expanded');
        },

        toggleSkeletonPreview(){

            this.skeletonPreview = !this.skeletonPreview;
            store.subpanel       = '';

            if (this.skeletonPreview) {
                document.getElementById('upb-wrapper').classList.remove('preview-default');
                document.getElementById('upb-wrapper').classList.add('preview-skeleton');
            }
            else {
                document.getElementById('upb-wrapper').classList.remove('preview-skeleton');
                document.getElementById('upb-wrapper').classList.add('preview-default');
            }
        },

        toggleResponsivePreview(id){

            this.devices.map((device) => {
                device.active = (device.id == id);
                document.getElementById('upb-wrapper').classList.remove(`preview-${device.id}`);
            });

            document.getElementById('upb-wrapper').classList.add(`preview-${id}`);
        }
    }
}