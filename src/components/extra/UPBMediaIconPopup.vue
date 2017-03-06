<template>
    <div tabindex="0" style="position:relative; display: block">
        <div class="media-modal wp-core-ui">
            <button type="button" @click="onCloseEvent()" class="button-link media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text"></span></span></button>
            <div class="media-modal-content">
                <div :class="mediaFrameClass">
                    <div class="media-frame-menu">
                        <div class="media-menu">
                            <a v-for="provider in iconProviders" @click.prevent="activeProvider(provider.id)" href="#" :class="{'media-menu-item':true, 'active':provider.active}" v-text="provider.title"></a>
                        </div>
                    </div>
                    <div class="media-frame-title">
                        <h1 v-text="title"></h1>
                    </div>
                    <div class="media-frame-router"></div>
                    <div class="media-frame-content" :data-columns="columns">
                        <div class="attachments-browser">

                            <div class="media-toolbar">
                                <div class="media-toolbar-secondary">
                                    <span :class="{spinner : true, 'is-active' : isLoading}"></span>
                                </div>
                                <div class="media-toolbar-primary search-form">
                                    <label for="media-search-input" class="screen-reader-text">Search Icon</label>
                                    <input type="search" v-model="searchIcon" placeholder="Search icons..." id="media-search-input" class="search">
                                </div>
                            </div>

                            <ul id="upb-attachments" tabindex="-1" class="attachments ui-sortable ui-sortable-disabled">
                                <li v-for="icon in icons" tabindex="0" :class="selectedIconClass(icon)">
                                    <div class="attachment-preview" @click.prevent="chooseIcon(icon)">
                                        <div class="thumbnail">
                                            <div class="icon-holder">
                                                <i :class="icon.id" :title="icon.name"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" @click.prevent="deSelectIcon()" class="button-link check" tabindex="-1">
                                        <span class="media-modal-icon"></span>
                                        <span class="screen-reader-text">Deselect</span>
                                    </button>
                                </li>
                            </ul>

                            <div class="media-sidebar">
                                <div tabindex="0" v-if="isSelected()" class="attachment-details save-ready">
                                    <h2>
                                        Icon Details
                                    </h2>
                                    <div class="attachment-info">
                                        <div class="thumbnail thumbnail-icon">
                                            <i :class="selected.id" :title="selected.name"></i>
                                        </div>
                                        <div class="details thumbnail-icon-details">
                                            <div class="filename" v-text="selected.name"></div>
                                            <div class="file-size" v-text="selected.provider"></div>
                                            <div class="compat-meta"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="media-frame-toolbar">
                        <div class="media-toolbar">
                            <div class="media-toolbar-secondary"></div>
                            <div class="media-toolbar-primary search-form">
                                <button type="button" @click="onInsertEvent()" :disabled="!isSelected()" class="button media-button button-primary button-large media-button-insert" v-text="button"></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="media-modal-backdrop"></div>
    </div>
</template>

<style type="text/css">
    .icon-holder {
        height          : 100%;
        display         : flex;
        align-items     : center;
        justify-content : center;
        font-size       : 3rem;
        }

    .attachment-info .thumbnail-icon {
        font-size   : 4rem;
        line-height : 100%;
        }

    .attachment-info .thumbnail-icon-details {
        margin-top : 10px;
        }

    .icon-holder i, .attachment-info i {
        width     : auto !important;
        height    : auto !important;
        font-size : inherit !important;
        }
</style>

<script src="./UPBMediaIconPopup.js"></script>

