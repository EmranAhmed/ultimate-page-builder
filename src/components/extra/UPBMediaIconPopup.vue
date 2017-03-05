<template>
    <div tabindex="0" style="position:relative; display: block">
        <div class="media-modal wp-core-ui">
            <button type="button" @click="onCloseEvent()" class="button-link media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text">Close media panel</span></span></button>
            <div class="media-modal-content">
                <div :class="mediaFrameClass">
                    <div class="media-frame-menu">
                        <div class="media-menu">
                            <a v-for="provider in iconProviders" href="#" :class="{'media-menu-item':true, 'active':provider.active}" v-text="provider.title"></a>
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
                                    <span class="spinner is-active"></span>
                                </div>
                                <div class="media-toolbar-primary search-form">
                                    <label for="media-search-input" class="screen-reader-text">Search Icon</label>
                                    <input type="search" placeholder="Search icons..." id="media-search-input" class="search">
                                </div>
                            </div>

                            <ul tabindex="-1" class="attachments ui-sortable ui-sortable-disabled">
                                <li tabindex="0" role="checkbox" aria-label="two" aria-checked="false" data-id="7" class="attachment save-ready">
                                    <div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">
                                        <div class="thumbnail">

                                            <div class="centered">
                                                <img src="http://sites.dev/wp-media/wp-content/uploads/2017/01/two-300x169.jpeg" draggable="false" alt="">
                                            </div>

                                        </div>

                                    </div>

                                    <button type="button" class="button-link check" tabindex="-1">
                                        <span class="media-modal-icon"></span>
                                        <span class="screen-reader-text">Deselect</span>
                                    </button>


                                </li>
                                <li tabindex="0" role="checkbox" aria-label="three" aria-checked="false" data-id="6" class="attachment save-ready">
                                    <div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">
                                        <div class="thumbnail">

                                            <div class="centered">
                                                <img src="http://sites.dev/wp-media/wp-content/uploads/2017/01/three-300x200.jpg" draggable="false" alt="">
                                            </div>

                                        </div>

                                    </div>

                                    <button type="button" class="button-link check" tabindex="-1"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>


                                </li>
                                <li tabindex="0" role="checkbox" aria-label="one" aria-checked="true" data-id="5" class="attachment save-ready selected details">
                                    <div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">
                                        <div class="thumbnail">

                                            <div class="centered">
                                                <img src="http://sites.dev/wp-media/wp-content/uploads/2017/01/one-300x200.jpeg" draggable="false" alt="">
                                            </div>

                                        </div>

                                    </div>

                                    <button type="button" class="button-link check" tabindex="-1"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>


                                </li>
                                <li tabindex="0" role="checkbox" aria-label="four" aria-checked="false" data-id="4" class="attachment save-ready">
                                    <div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">
                                        <div class="thumbnail">

                                            <div class="centered">
                                                <img src="http://sites.dev/wp-media/wp-content/uploads/2017/01/four-300x200.jpeg" draggable="false" alt="">
                                            </div>

                                        </div>

                                    </div>

                                    <button type="button" class="button-link check" tabindex="0"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>


                                </li>
                            </ul>


                            <div class="media-sidebar">
                                <div tabindex="0" data-id="4" class="attachment-details save-ready">
                                    <h2>
                                        Attachment Details
                                    </h2>
                                    <div class="attachment-info">
                                        <div class="thumbnail thumbnail-image">

                                            <img src="http://sites.dev/wp-media/wp-content/uploads/2017/01/four-300x200.jpeg" draggable="false" alt="">

                                        </div>
                                        <div class="details">
                                            <div class="filename">four.jpeg</div>
                                            <div class="uploaded">January 17, 2017</div>

                                            <div class="file-size">75 KB</div>


                                            <div class="dimensions">1280 × 853</div>


                                            <a class="edit-attachment" href="http://sites.dev/wp-media/wp-admin/post.php?post=4&amp;action=edit&amp;image-editor" target="_blank">Edit Image</a>


                                            <button type="button" class="button-link delete-attachment">Delete Permanently</button>


                                            <div class="compat-meta">

                                            </div>
                                        </div>
                                    </div>

                                    <label class="setting" data-setting="url">
                                        <span class="name">URL</span>
                                        <input type="text" value="http://sites.dev/wp-media/wp-content/uploads/2017/01/four.jpeg" readonly="">
                                    </label>

                                    <label class="setting" data-setting="title">
                                        <span class="name">Title</span>
                                        <input type="text" value="four">
                                    </label>

                                    <label class="setting" data-setting="caption">
                                        <span class="name">Caption</span>
                                        <textarea></textarea>
                                    </label>

                                    <label class="setting" data-setting="alt">
                                        <span class="name">Alt Text</span>
                                        <input type="text" value="">
                                    </label>

                                    <label class="setting" data-setting="description">
                                        <span class="name">Description</span>
                                        <textarea></textarea>
                                    </label>
                                </div>
                                <form class="compat-item"></form>
                            </div>
                        </div>
                    </div>
                    <div class="media-frame-toolbar">
                        <div class="media-toolbar">
                            <div class="media-toolbar-secondary"></div>
                            <div class="media-toolbar-primary search-form">
                                <button type="button" @click="onInsertEvent()" :disabled="!isSelected()" class="button media-button button-primary button-large media-button-insert">Insert</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="media-modal-backdrop"></div>
    </div>
</template>

<script src="./UPBMediaIconPopup.js"></script>

