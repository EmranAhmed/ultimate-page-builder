<template>
    <div id="upb-sidebar-contents">
        <ul>
            <li><a href="#" title="Close"><i class="mdi mdi-window-close"></i></a></li>
            <li :class="{ active: item.active }" v-for="item in model"><a href="#" :title="item.title"><i :class="item.icon"></i></a></li>
            <li><a href="#" title="Save"><i class="mdi mdi-content-save-all"></i></a></li>
        </ul>
    </div>



</template>
<style src="../scss/upb-sidebar-contents.scss" lang="sass"></style>
<script>

    export default {
        name  : 'upb-sidebar-contents',
        props : ['parent', 'index', 'model']
    }
</script>
