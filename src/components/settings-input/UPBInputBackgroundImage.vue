<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <div class="description" v-if="attributes.desc" v-html="attributes.desc"></div>
            </label>

            <div v-image-media class="attachment-media-view">
                <div v-show="input" class="preview background-preview">

                    <div class="pointer" v-background-position="positions"></div>

                    <img :src="input" alt="" draggable="false">
                </div>

                <div v-show="!input" class="placeholder" v-text="attributes.placeholder"></div>

                <div class="actions">
                    <button v-show="input" type="button" class="button remove-button" v-text="attributes.buttons.remove"></button>
                    <button type="button" class="button new-button" v-text="attributes.buttons.choose"></button>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
                <div class="description" v-if="attributes.desc" v-html="attributes.desc"></div>
            </label>
        </div>
    </li>
</template>
<script src="./UPBInputBackgroundImage.js"></script>