<template>
    <ul>
        <li :class="className()" v-if="path.length > 0">
            <a href="#" v-for="(b, index) in breadcrumb" :key="index" v-text="b.title" @click.prevent="goTo(b.link)"></a>
        </li>
        <li class="no-breadcrumb" v-else v-text="l10n.breadcrumbRoot"></li>
    </ul>
</template>
<script src="./UPBBreadcrumb.js"></script>
