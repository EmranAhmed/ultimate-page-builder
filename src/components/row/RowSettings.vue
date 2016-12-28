<template>
    <ul :class="panelClass()">

        <li class="upb-panel-header-wrapper">
            <ul>
                <li class="upb-panel-header">

                    <a :title="l10n.back" v-if="isSubPanel()" href="#" class="back" @click.prevent="back()">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>

                    <div class="panel-heading-wrapper">
                        <div class="panel-heading">
                            <div class="upb-breadcrumb">
                                <upb-breadcrumb></upb-breadcrumb>
                            </div>

                            <div class="panel-title" v-text="panelTitle"></div>
                        </div>

                        <button v-if="panelMetaHelp" @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>

                        <button v-if="panelMetaSearch" @click.prevent="toggleFilter()" :class="[{ active: showSearch }, 'upb-content-search-toggle']" tabindex="0">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </li>

                <li class="upb-panel-meta">
                    <div v-if="showHelp" v-html="panelMetaHelp"></div>

                    <!--<div v-if="showSearch">
                        <input v-model="searchQuery" :placeholder="panelMetaSearch" type="search">
                    </div>-->
                </li>


                <li class="upb-panel-tools">
                    <ul>
                        <li v-for="tool in panelMetaTools">
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
                <component v-for="(settings, index) in contents._upb_settings" :index="index" keyindexname="id" keyvaluename="value" :items="contents._upb_settings" :item="contents" :attributes="settings" :target="settings.id" :model="item.attributes" :is="settings._upb_field_type"></component>
            </ul>
        </li>
    </ul>
</template>

<script src="./RowSettings.js"></script>
