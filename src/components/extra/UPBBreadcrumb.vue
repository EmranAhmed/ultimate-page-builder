<template>
    <ul>


        <!--
                <li class="breadcrumb" v-if="breadcrumb.length > 0" v-for="b in breadcrumb" v-text="b.title" @click="goTo(b.link)"></li>
        -->
        <li :class="className()" v-if="breadcrumb.length > 0">
            <a href="#" v-for="b in breadcrumb" v-text="b.title" @click.prevent="goTo(b.link)"></a>
        </li>
        <li class="no-breadcrumb" v-else v-text="l10n.breadcrumbRoot"></li>
    </ul>
</template>
<script src="./UPBBreadcrumb.js"></script>
