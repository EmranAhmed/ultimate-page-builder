<template>
    <li :class="{ active: model.active }">
        <a href="#" @click.prevent="activeTab()" :title="model.title"><i :class="model.icon"></i></a>
    </li>
</template>
<script src="./UPBSidebarHeaderItem.js"></script>