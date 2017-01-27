<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">

            <label v-if="multiple">
                <span class="title" v-text="attributes.title"></span>
                <select class="select2-multiple-input" multiple v-model="input" style="width: 100%" v-select2="settings">
                    <option v-for="(option, value) in attributes.options" :data-icon="option.icon" :value="value" :title="option.title" v-text="option.title"></option>
                </select>
            </label>

            <label v-else>
                <span class="title" v-text="attributes.title"></span>
                <select class="select2-input" v-model="input" style="width: 100%" v-select2="settings">
                    <option v-for="(option, value) in attributes.options" :data-icon="option.icon" :value="value" :title="option.title" v-text="option.title"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script src="./UPBInputSelectBoxIcon.js"></script>