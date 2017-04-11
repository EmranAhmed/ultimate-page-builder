<template>
    <li :class="typeClass()" v-show="isRequired">
        <div class="form-group">
            <div class="title-wrapper">
                <i v-if="attributes.deviceIcon" :class="deviceClass" :title="attributes.deviceTitle"></i>
                <span class="title" v-text="attributes.title"></span>
            </div>

            <!-- <span class="title" v-text="`${attributes.title} ( ${attributes.unit} )`"></span> -->
            <!-- // Should maintain serial: 1. top, 2. right, 3. bottom, 4. left -->
            <div class="spacing-input-group">
                <label v-for="(option, key) in options">
                    <input :disabled="!option" v-model="property[key]" type="number" class="tiny-text">
                    <span class="spacing-title" v-text="attributes.titles[key]"></span>
                </label>

                <label @click="toggleShorthand()" class="shorthand-toggle">
                    <i v-if="shorthand" class="mdi mdi-link"></i>
                    <i v-else class="mdi mdi-link-off"></i>
                </label>
            </div>

            <div class="clear"></div>
            <p class="description" v-if="attributes.desc" v-html="attributes.desc"></p>
        </div>
    </li>
</template>
<script src="./UPBInputSpacing.js"></script>