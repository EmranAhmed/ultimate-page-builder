<template>
    <ul :class="panelClass">

        <li v-if="!showChild" class="upb-panel-header-wrapper">
            <ul>
                <li class="upb-panel-header">

                    <div class="panel-heading-wrapper">
                        <div class="panel-heading">

                            <div class="upb-breadcrumb">

                                <ul>
                                    <li class="no-breadcrumb">{{ l10n.breadcrumbRoot }}</li>
                                </ul>

                            </div>

                            <div class="panel-title">{{ model.title }}</div>
                        </div>

                        <button @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>

                        <button @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
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
                            <a @click.prevent="callToolsAction($event, tool.action, tool)" href="#">
                                <i :class="tool.icon"></i>
                                <div v-text="tool.title"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <li v-if="!showChild" class="upb-panel-contents">
            <ul class="upb-panel-contents-items" v-sortable="sortable">
                <component v-for="(item, index) in contents" @showSettingsPanel="showSettingsPanel(index)" @showContentPanel="showContentPanel(index)" @deleteItem="deleteItem(index)"
                           :model="item" @cloneItem="cloneItem(index, item)" :is="listPanel(item.id)"></component>
            </ul>
        </li>

        <li v-if="showChild" class="upb-sub-panel">
            <component :index="childId" @showSettingsPanel="showSettingsPanel(childId)" @showContentPanel="showContentPanel(childId)" :model="singleModel()" @onBack="backed()"
                       :is="childComponent"></component>
        </li>

    </ul>
</template>

<script src="./SettingsPanel.js"></script>
