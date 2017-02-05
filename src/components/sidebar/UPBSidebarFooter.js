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
            this.sidebarExpand    = false;
            store.sidebarExpanded = false;
            store.subpanel        = '';
            document.getElementById('upb-wrapper').classList.remove('expanded');
            document.getElementById('upb-wrapper').classList.add('collapsed');
        },

        expandSidebar(){
            this.sidebarExpand    = true;
            store.sidebarExpanded = true;
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

        toggleResponsivePreview(device){

            this.devices.map((d) => {
                d.active = (d.id == device.id);
                document.getElementById('upb-wrapper').classList.remove(`preview-${d.id}`);
            });

            store.currentPreviewDevice = device.id;

            document.getElementById('upb-wrapper').classList.add(`preview-${device.id}`);

            if (device['width']) {
                document.getElementById('upb-preview-wrapper').style.width = device.width;
            }
            if (device['height']) {
                document.getElementById('upb-preview-wrapper').style.height = device.height;
            }
            else {
                document.getElementById('upb-preview-wrapper').style.height = '100%';
            }
        }
    }
}