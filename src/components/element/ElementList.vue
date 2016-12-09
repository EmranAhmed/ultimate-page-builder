<template>
    <li :class="itemClass()" @mouseover="activeFocus()" @mouseout="removeFocus()">

        <ul class="tools">
            <li v-for="tool in toolsList()" @click="clickActions(tool.id, tool)" v-if="enabled(tool.id)" :title="tool.title" :class="toolsClass(tool.id, tool)">
                <i :class="tool.icon"></i>
            </li>
        </ul>
        <div v-text="title()"></div>
    </li>
</template>
<script src="./ElementList.js"></script>
