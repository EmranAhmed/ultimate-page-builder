<template>
    <div id="sidebar-sub-panel-sections">

        <div class="sub-panel-sections-header">

            <input v-model="searchQuery" type="search">

            <button @click="toggleTextarea()"><i class="mdi mdi-clipboard-text"></i></button>

        </div>

        <div v-if="showTextarea" class="sub-panel-sections-load">

            <textarea v-model="textareaContents" :placeholder="l10n.pasteJSON"></textarea>

            <button @click.prevent="addToSection()" v-text="l10n.add"></button>
        </div>

        <div class="sub-panel-sections-list">


            <ul>
                <li v-for="(content, index) in contents">
                    <div class="sub-panel-section-tools">
                        <a @click.prevent="addSection(index)" href=""><i class="mdi mdi-plus"></i></a>
                        <a @click.prevent="copyToClipboard(index)" href=""><i class="mdi mdi-clipboard-outline"></i></a>
                        <a @click.prevent="deleteSection(index)" href="#"><i class="mdi mdi-close"></i></a>

                    </div>
                    <div class="sub-panel-section-title" v-text="content.attributes.title"></div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script src="./UPBSubPanelSections.js"></script>