<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label v-if="multiple">
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select multiple class="select2-input select2-input-multiple" style="width: 100%" v-select2="settings" :id="attributes._id">
                    <option v-for="option in options" selected="selected" :value="option.id" :title="option.title" v-text="option.text"></option>
                </select>
            </label>
            <label v-else>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select2-input" style="width: 100%" v-select2="settings" :id="attributes._id">
                    <option :value="input" :title="options.title" v-text="options.text"></option>
                </select>
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputAjaxSelect.js"></script>