<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <upb-media-icon-popup v-if="show" :providers="providers" @insert="iconSelected($event)" @close="closePopup()"></upb-media-icon-popup>
            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>


                <button class="button" @click="openPopup()">Show Modal</button>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputIconPopup.js"></script>