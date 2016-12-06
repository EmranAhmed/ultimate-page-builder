<template>

    <ul :class="panelClass()">

        <li class="upb-panel-header-wrapper">
            <ul>
                <li class="upb-panel-header">

                    <div class="panel-heading-wrapper">
                        <div class="panel-heading">

                            <div class="upb-breadcrumb">
                                <upb-breadcrumb></upb-breadcrumb>
                            </div>

                            <div class="panel-title" v-text="model.title"></div>
                        </div>

                        <button v-if="model.help" @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>

                        <button v-if="model.search" @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>

                </li>

                <li class="upb-panel-meta">
                    <div v-if="showHelp" v-html="model.help"></div>

                    <div v-if="showSearch">
                        <input v-model="searchQuery" :placeholder="model.search" type="search">
                    </div>
                </li>

                <li class="upb-panel-tools">
                    <ul>
                        <li v-for="tool in model.tools">
                            <a @click.prevent="toolsAction(tool, $event)" href="#">
                                <i :class="tool.icon"></i>
                                <div v-text="tool.title"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="upb-panel-contents">
            <ul class="upb-panel-contents-items">
                <component v-for="(item, index) in contents" :index="index" :model="item" is="upb-elements-list"></component>
            </ul>
        </li>
    </ul>
</template>
<script src="./ElementsPanel.js"></script>