<template>
    <li :class="typeClass()" v-if="isRequired">
        <div class="form-group">
            <label>
                <span class="title" v-text="attributes.title"></span>
            </label>

            <div :id="wrapperId"></div>

            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>

        </div>
    </li>
</template>
<script src="./UPBInputEditor.js"></script>