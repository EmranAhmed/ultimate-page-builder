import store from '../../store'

export default {
    name  : 'upb-sidebar-footer',
    props : ['index', 'model'],
    data(){
        return {
            l10n            : store.l10n,
            devices         : store.devices,
            sidebarExpand   : true,
            skeletonPreview : false,
            deviceWidths    : {},
            actualDevice    : '',
            deviceSwitched  : false,
            currentDevices  : []
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

    created(){

        this.deviceWidths = this.devices.reduce((widths, device) => {
            widths[device.id] = parseFloat(device.width);
            return widths;
        }, {});

        this.windowResize();

        window.addEventListener('resize', ()=> this.windowResize());
    },

    methods : {

        windowResize : _.debounce(function () {
            // console.log(window.innerWidth); // 1400

            this.deviceSwitched = false;

            this.currentDevices = Object.keys(this.deviceWidths).filter((deviceId)=> {
                return (window.innerWidth >= this.deviceWidths[deviceId]);
            });

            let lastDevice = _.last(Object.keys(this.deviceWidths));

            if (this.currentDevices.length < 1) {
                this.currentDevices.push(lastDevice);
            }

            this.actualDevice = this.currentDevices[0];

            this.devices.map((d) => {
                d.active = (d.id == this.actualDevice);
            });

            this.toggleResponsivePreviewWidth(this.actualDevice);
            // this.toggleResponsivePreview(this.actualDevice);

        }, 300),

        deviceAvailable(deviceId){
            return this.currentDevices.includes(deviceId);
        },

        currentDevice(deviceId){
            return this.devicePreview == deviceId;
        },

        collapseSidebar(){
            this.sidebarExpand    = false;
            store.sidebarExpanded = false;
            store.subpanel        = '';
            document.getElementById('upb-wrapper').classList.remove('expanded');
            document.getElementById('upb-wrapper').classList.add('collapsed');
            //this.windowResize();
        },

        expandSidebar(){
            this.sidebarExpand    = true;
            store.sidebarExpanded = true;
            document.getElementById('upb-wrapper').classList.remove('collapsed');
            document.getElementById('upb-wrapper').classList.add('expanded');
            //this.windowResize();
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

        toggleResponsivePreviewWidth(deviceId){

            document.getElementById('upb-wrapper').classList.add(`preview-${deviceId}`);

            // console.log('clicked: ', deviceId, 'actual: ', this.actualDevice);

            if (this.actualDevice == deviceId) {
                document.getElementById('upb-preview-wrapper').style.width = '100%';
            }
            else {
                if (this.deviceWidths[deviceId]) {
                    document.getElementById('upb-preview-wrapper').style.width = `${this.deviceWidths[deviceId]}px`;
                }
            }
        },

        toggleResponsivePreview(deviceId){

            this.devices.map((d) => {
                d.active = (d.id == deviceId);
                document.getElementById('upb-wrapper').classList.remove(`preview-${d.id}`);
            });

            this.deviceSwitched = true;

            store.currentPreviewDevice = deviceId;

            this.toggleResponsivePreviewWidth(deviceId);
        }
    }
}