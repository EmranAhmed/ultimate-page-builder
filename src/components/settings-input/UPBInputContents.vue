<template>
    <li :class="typeClass()">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
            </label>

            <textarea :id="id" class="wp-editor-area text" v-model="input" style="height: 200px" rows="16" cols="20"></textarea>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputContents.js"></script>