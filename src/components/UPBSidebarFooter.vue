<template>
    <div id="upb-sidebar-footer">
        <a :class="[{ current: sidebarExpand }, 'btn-collapse']" :title="l10n.collapse" @click.prevent="collapseSidebar()" href="#"><i class="mdi mdi-arrow-left-drop-circle-outline"></i></a>
        <a :class="[{ current: !sidebarExpand }, 'btn-expand']" :title="l10n.expand" @click.prevent="expandSidebar()" href="#"><i class="mdi mdi-arrow-right-drop-circle"></i></a>
        <div class="previews">
            <a :class="{ active: skeletonPreview }" :title="l10n.skeleton" @click.prevent="toggleSkeletonPreview()" href="#"><i class="mdi mdi-group"></i></a>

            <a v-for="device in devices" :class="{ active: currentDevice(device.id) }" :title="device.title" @click.prevent="toggleResponsivePreview(device.id)" href="#"><i
                    :class="device.icon"></i></a>

        </div>
    </div>
</template>
<style src="../scss/upb-sidebar-footer.scss" lang="sass"></style>
<script>

    import store from '../store'

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
                return this.devices.map(function (device) {
                    if (device.active) {
                        return device.id
                    }
                }).join('');
            }
        },

        methods : {
            collapseSidebar(){
                this.sidebarExpand = false;
                document.getElementById('upb-wrapper').classList.remove('expanded');
                document.getElementById('upb-wrapper').classList.add('collapsed');
            },

            currentDevice(device){
                return this.devicePreview == device;
            },

            expandSidebar(){
                this.sidebarExpand = true;
                document.getElementById('upb-wrapper').classList.remove('collapsed');
                document.getElementById('upb-wrapper').classList.add('expanded');
            },

            toggleSkeletonPreview(){

                this.skeletonPreview = !this.skeletonPreview;

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

                this.devices.map(function (device) {
                    device.active = (device.id == id) ? true : false;
                    document.getElementById('upb-wrapper').classList.remove(`preview-${device.id}`);
                });
                document.getElementById('upb-wrapper').classList.add(`preview-${id}`);
            }
        }
    }
</script>
