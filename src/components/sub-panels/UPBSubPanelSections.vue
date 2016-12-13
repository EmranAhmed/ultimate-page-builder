<template>
    <div id="sidebar-sub-panel-sections">

        <div class="sub-panel-sections-header">

            <input v-model="searchQuery" type="search">

            <button @click="toggleTextarea()"><i class="mdi mdi-clipboard-text"></i></button>

        </div>

        <div v-if="showTextarea" class="sub-panel-sections-load">

            <textarea v-model="textareaContents" placeholder="paste section json"></textarea>

            <button>Add</button>
        </div>

        <div class="sub-panel-sections-list">


            {{ contents }}

            <ul>
                <li>
                    <div>
                        <a href="">add</a>
                        <a href="">code</a>
                        <a href="">remove</a>
                    </div>
                    <div>Slider Section</div>
                </li>

            </ul>


        </div>

    </div>
</template>
<script src="./UPBSubPanelSections.js"></script>