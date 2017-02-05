<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <label v-if="multiple">
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select2-multiple-input" multiple v-model="input" style="width: 100%" v-select2="settings">
                    <option v-for="(option, value) in attributes.options" :data-icon="option.icon" :value="value" :title="option.title" v-text="option.title"></option>
                </select>
            </label>
            <label v-else>
                <div class="title-wrapper">
                    <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                    <span class="title" v-text="attributes.title"></span>
                </div>
                <select class="select2-input" v-model="input" style="width: 100%" v-select2="settings">
                    <option v-for="(option, value) in attributes.options" :data-icon="option.icon" :value="value" :title="option.title" v-text="option.title"></option>
                </select>
            </label>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputSelect2Icon.js"></script>