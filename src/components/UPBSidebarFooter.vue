<template>
    <div id="upb-sidebar-footer">
        <a :class="[{ current: sidebarExpand }, 'btn-collapse']" :title="l10n.collapse" @click.prevent="collapseSidebar()" href="#"><i class="mdi mdi-arrow-left-drop-circle-outline"></i></a>
        <a :class="[{ current: !sidebarExpand }, 'btn-expand']" :title="l10n.expand" @click.prevent="expandSidebar()" href="#"><i class="mdi mdi-arrow-right-drop-circle"></i></a>
        <div class="previews">
            <a :class="{ active: skeletonPreview }" :title="l10n.skeleton" @click.prevent="toggleSkeletonPreview()" href="#"><i class="mdi mdi-group"></i></a>
            <a :class="{ active: currentDevice('lg') }" :title="l10n.large" @click.prevent="toggleResponsivePreview('lg')" href="#"><i class="mdi mdi-desktop-mac"></i></a>
            <a :class="{ active: currentDevice('md') }" :title="l10n.medium" @click.prevent="toggleResponsivePreview('md')" href="#"><i class="mdi mdi-laptop-mac"></i></a>
            <a :class="{ active: currentDevice('sm') }" :title="l10n.small" @click.prevent="toggleResponsivePreview('sm')" href="#"><i class="mdi mdi-tablet-ipad"></i></a>
            <a :class="{ active: currentDevice('xs') }" :title="l10n.xSmall" @click.prevent="toggleResponsivePreview('xs')" href="#"><i class="mdi mdi-cellphone-iphone"></i></a>
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
                sidebarExpand   : true,
                skeletonPreview : false,
                devicePreview   : 'lg'
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

            toggleResponsivePreview(device){
                this.devicePreview = device;

                ['lg', 'md', 'sm', 'xs'].map(function (device) {
                    document.getElementById('upb-wrapper').classList.remove(`preview-${device}`);
                });

                document.getElementById('upb-wrapper').classList.add(`preview-${device}`);

            }
        }
    }
</script>
