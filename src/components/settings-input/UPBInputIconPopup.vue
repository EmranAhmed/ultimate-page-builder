<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">

            <upb-media-icon-popup v-if="show" :title="attributes.title" :button="attributes.buttons.add" :providers="providers" @insert="iconSelected($event)" @close="closePopup()"></upb-media-icon-popup>

            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
            </label>

            <div class="attachment-icon-view">

                <div v-if="input" class="preview">
                    <i :class="input"></i>
                </div>

                <div v-else class="placeholder"></div>

                <div class="actions">
                    <button @click.prevent="openPopup()" type="button" class="button icon-modal-popup" v-text="attributes.buttons.choose"></button>
                    <button v-if="input" @click.prevent="removeIcon()" type="button" class="button remove-button" v-text="attributes.buttons.remove"></button>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
            </div>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputIconPopup.js"></script>