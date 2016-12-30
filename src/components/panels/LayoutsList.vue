<template>
    <li class="upb-layout-list">

        <div class="preview-image-wrapper">
            <a @click.prevent="useLayout()" href="#" :title="l10n.layoutUse">
                <img :src="image" draggable="false" :alt="model.title">
            </a>
        </div>

        <div class="layouts-contents">
            <div v-text="model.title"></div>
            <div v-text="model.desc"></div>
        </div>
    </li>
</template>
<script src="./LayoutsList.js"></script>