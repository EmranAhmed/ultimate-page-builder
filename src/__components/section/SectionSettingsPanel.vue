<template>
    <ul :class="panelClass()">


        <li v-if="!showChild" class="upb-panel-header-wrapper">
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
                                    <li class="no-breadcrumb" v-else v-text="l10n.breadcrumbRoot"></li>
                                </ul>
                            </div>

                            <div class="panel-title" v-text="panelTitle"></div>
                        </div>

                        <button @click.prevent="toggleHelp()" :class="[{ active: showHelp }, 'upb-content-help-toggle']" tabindex="0">
                            <i class="mdi mdi-help-circle-outline"></i>
                        </button>


                    </div>
                </li>

                <li class="upb-panel-meta">
                    <div v-if="showHelp" v-html="model._upb_options.meta.settings.help"></div>


                </li>

                <li class="upb-panel-tools">
                    <ul>
                        <li v-for="tool in model._upb_options.tools.settings">
                            <a @click.prevent="toolsAction(tool, $event)" href="#">
                                <i :class="tool.icon"></i>
                                <div v-text="tool.title"></div>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </li>
    </ul>
</template>

<script src="./SectionSettingsPanel.js"></script>
