<template>
    <div id="upb-preview" class="upb-wrapper">


        <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>

    </div>
</template>
<style src="./scss/upb-preview.scss" lang="sass"></style>
<script>

    import store from './store'

    // wp.shortcode.string({
    // tag:'gallery',
    // attrs:{a:1},
    // content:''
    // })
    // wp.shortcode.replace('gallery', 'hello [gallery]', function(shortcode){ return 'xxxxx' })

    Vue.component('upb-section', function (resolve, reject) {

        store.getShortCodePreviewTemplate('section', function (data) {

            resolve({
                template : data,
                props    : ['index', 'model'],
                data(){
                    return {
                        shortcode : '',
                        contents  : '',
                    }
                },

                computed : {
                    $router(){
                        return this.$root.$data.store.panel._router;
                    },
                    $route(){
                        return this.$root.$data.store.panel._route;
                    },
                },

                created(){

                    this.shortcode = this.getShortCode();

                    console.log(this.shortcode);

                    this.getContents(this.shortcode);

                    //console.log(Vue)

                    this.$watch(`model.attributes`, function (value) {

                        console.log(this.$slots.default);

                        this.shortcode = this.getShortCode();
                        this.getContents(this.shortcode);

                    }.bind(this), {deep : true});

                    this.$watch(`model.contents`, function (value) {

                        this.shortcode = this.getShortCode();
                        this.getContents(this.shortcode);

                    }.bind(this));

                },

                methods : {


                    activeFocus(){
                        this.model._upb_options.focus = true;
                    },

                    removeFocus(){
                        this.model._upb_options.focus = false;
                    },

                    openContentsPanel(){
                        this.$router.replace(`/sections`)
                        // Async
                        setTimeout(function () {
                            this.$router.push({
                                name   : `section-contents`,
                                params : {
                                    tab       : 'sections',
                                    sectionId : this.index,
                                    type      : 'contents'
                                }
                            });
                        }.bind(this), 10)
                    },

                    openSettingsPanel(){
                        this.$router.replace(`/sections`)
                        // Async
                        setTimeout(function () {
                            this.$router.push({
                                name   : `section-settings`,
                                params : {
                                    tab       : 'sections',
                                    sectionId : this.index,
                                    type      : 'settings'
                                }
                            });
                        }.bind(this), 10)
                    },

                    getContents(html){

                        console.log(html);

                        store.getShortCodePreview(html, function (data) {




                            //let d = data.replace('%CONTENTS%', this.$slots.default.toString() );

                            this.contents = data;

                        }.bind(this), function () {

                        });

                        // console.log(html);
                    },

                    getShortCode(){


                        // let a = Vue.compile('<div><component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component></div>');



                        //console.log(a.render.toString());

                        console.log(this)

                        return wp.shortcode.string({
                            tag     : this.model.tag,
                            attrs   : this.model.attributes,
                            content : '%_WE_NEED_TO_SET_COMPONENT_COMPILED_TEMPLATE_%',
                            // content : '<component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component>',
                            //content : this.$compile('<div><component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component></div>')
                        })
                    },

                }

            })

        }, function () {

        })

    });

    Vue.component('upb-row', function (resolve, reject) {

        store.getShortCodePreviewTemplate('row', function (data) {

            resolve({
                template : data,
                props    : ['index', 'model'],
                data(){
                    return {
                        shortcode : '',
                        contents  : '',
                    }
                },

                created(){

                    this.shortcode = this.getShortCode();

                    console.log(this.shortcode);

                    this.getContents(this.shortcode);

                    //console.log(Vue)

                    this.$watch(`model.attributes`, function (value) {

                        console.log(this.$slots.default);

                        this.shortcode = this.getShortCode();
                        this.getContents(this.shortcode);

                    }.bind(this), {deep : true});

                    this.$watch(`model.contents`, function (value) {

                        this.shortcode = this.getShortCode();
                        this.getContents(this.shortcode);

                    }.bind(this));

                },

                methods : {

                    getContents(html){

                        store.getShortCodePreview(html, function (data) {

                            //let d = data.replace('%CONTENTS%', this.$slots.default.toString() );

                            this.contents = data;

                        }.bind(this), function () {

                        });

                        // console.log(html);
                    },

                    getShortCode(){

                        return wp.shortcode.string({
                            tag     : this.model.tag,
                            attrs   : this.model.attributes,
                            content : '%_WE_NEED_TO_SET_COMPONENT_COMPILED_TEMPLATE_%',

                            //content : this.$compile('<div><component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`"></component></div>')
                        })
                    },
                }
            })

        }, function () {

        })

    });

    Vue.component('upb-column', function (resolve, reject) {

        store.getShortCodePreviewTemplate('column', function (data) {

            resolve({
                template : data,
                props    : ['index', 'model']
            })

        }, function () {

        })

    });


    import Vue from 'vue';
    export default {
        name     : 'upb-preview',
        data(){
            return {
                sections : this.$root.$data,
                preview  : ''
            }
        },
        computed : {
            model(){
                return this.sections.store.tabs.filter(function (data) {
                    return data.id == 'sections' ? data : false;
                })[0]
            },
            shortcodes(){
                //return this.getPreview();
                return this.model.contents.map(function (m, i) {
                    m.attributes['__index'] = i;
                    return this.getShortCode(m.tag, m.attributes, m.contents);
                }.bind(this)).join('');
            }
        },
        created(){
            this.getPreview();

        },
        methods  : {
            getPreview(){
                //console.log(this.shortcodes);
                return this.sections.store.getShortCodePreview(this.shortcodes, function (data) {
                    this.preview = data
                }.bind(this), function () {
                })
            },
            getShortCode(tag, attrs, contents){
                return wp.shortcode.string({
                    tag     : tag,
                    attrs   : attrs,
                    content : this.getContents(contents, attrs.__index)
                })
            },
            getContents(contents, index){
                if (Array.isArray(contents)) {
                    return contents.map(function (m, i) {
                        m.attributes['__index'] = `${index}/${i}`
                        return this.getShortCode(m.tag, m.attributes, m.contents, i);
                    }.bind(this)).join('')
                }
                else {
                    return contents;
                }
            }
        }
    }
</script>