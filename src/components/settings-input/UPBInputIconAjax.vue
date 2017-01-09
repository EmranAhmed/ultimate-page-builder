<template>
    <li :class="typeClass()" v-if="isRequired">
        <div class="form-group">
            <label>

                <span class="title" v-text="attributes.title"></span>
                <select class="select2-input" style="width: 100%" v-select2="settings" :id="attributes._id">
                    <option :value="input" :title="attributes.options.title" v-text="attributes.options.text"></option>
                </select>
            </label>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>

<script src="./UPBInputIconAjax.js"></script>