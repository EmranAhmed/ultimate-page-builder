<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
            </label>

            <div :id="wrapperId"></div>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>

        </div>
    </li>
</template>
<script src="./UPBInputEditor.js"></script>