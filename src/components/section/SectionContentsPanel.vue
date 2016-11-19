<template>
    <ul :class="panelClass">

        <li class="upb-panel-header-wrapper">
            <ul>
                <li class="upb-panel-header">

                    <a :title="l10n.back" href="" class="back" @click.prevent="back()">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>

                    <div class="panel-heading-wrapper">
                        <div class="panel-heading">

                            <div class="upb-breadcrumb">
                                <ul>
                                    <li class="breadcrumb" v-if="breadcrumb.length > 0" v-for="b in breadcrumb">{{ b }}</li>
                                    <li class="no-breadcrumb" v-else>{{ l10n.breadcrumbRoot }}</li>
                                </ul>
                            </div>

                            <div class="panel-title">{{ model.attributes.title }}</div>
                        </div>

                        <button v-if="model._upb_options.help" @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>

                        <button v-if="model._upb_options.search" @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </li>

                <li class="upb-panel-meta">
                    <div v-if="showHelp" v-html="model._upb_options.help"></div>

                    <div v-if="showSearch">
                        <input v-model="searchQuery" :placeholder="model._upb_options.search" type="search">
                    </div>
                </li>

                <li class="upb-panel-tools">
                    <ul>
                        <li v-for="tool in model._upb_options.tools.contents">
                            <a @click.prevent="callToolsAction($event, tool.action, tool)" href="#">
                                <i :class="tool.icon"></i>
                                <div v-text="tool.title"></div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="upb-panel-contents">
            <ul class="upb-panel-contents-items" v-sortable="sortable">
                <component v-for="(item, index) in contents" :index="index" :selected="childId" @showSettingsPanel="openSettingsPanel(index)" @showContentsPanel="openContentsPanel(index)"
                           @deleteItem="deleteItem(index)"
                           :model="item" @cloneItem="cloneItem(index, item)" :is="listPanel(item.tag)"></component>
            </ul>


            <component v-for="(item, index) in contents" v-if="isCurrentRow(index)" :index="index" :model="item" :is="childComponent"></component>

        </li>


    </ul>
</template>
<style lang="sass"></style>
<script src="./SectionContentsPanel.js"></script>
