<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select2-input" v-model="input" style="width: 100%" v-select2="settings" :id="attributes._id">
                    <option v-for="(option, value) in attributes.options" :value="value" v-text="option"></option>
                </select>
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputIconSelect.js"></script>