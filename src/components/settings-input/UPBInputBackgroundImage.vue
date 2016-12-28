<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <div class="description" v-if="attributes.desc" v-html="attributes.desc"></div>

            </label>

            <div v-image-media class="attachment-media-view">
                <div v-if="input" class="preview background-preview">
                    <img :src="input" alt="" draggable="false">
                </div>

                <div v-else class="placeholder" v-text="attributes.placeholder"></div>

                <div class="actions">
                    <button v-show="input" type="button" class="button remove-button" v-text="attributes.buttons.remove"></button>
                    <button type="button" class="button new-button" v-text="attributes.buttons.choose"></button>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </li>
</template>
<script src="./UPBInputBackgroundImage.js"></script>