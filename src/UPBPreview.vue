<template>
    <div id="upb-preview" class="upb-wrapper">

        <component v-for="(content, index) in model.contents" :index="index" :model="content" :is="`upb-${content.tag}`">
        </component>

    </div>
</template>
<style src="./scss/upb-preview.scss" lang="sass"></style>
<script>

    // wp.shortcode.string({
    // tag:'gallery',
    // attrs:{a:1},
    // content:''
    // })
    // wp.shortcode.replace('gallery', 'hello [gallery]', function(shortcode){ return 'xxxxx' })

    Vue.component('upb-section', {
        //template : '<button>{{ attributes }}</button>',
        template : '#upb-section-template',
        //render: createElement=>createElement(),
        props    : ['index', 'model'],

        data(){
            return {
                //$router : this.$root.$data.store.panel._router
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
            }
        }
    });

    Vue.component('upb-row', {
        //template : '<button>{{ attributes }}</button>',
        template : '#upb-row-template',
        //render: createElement=>createElement(),
        props    : ['index', 'model'],

        data(){
            return {
                //$router : this.$root.$data.store.panel._router
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
            }
        }
    });






    import Vue from 'vue';

    export default {
        name : 'upb-preview',
        data(){
            /*return {
             sections : this.$root.$data,
             preview  : ''
             }*/
            return this.$root.$data;
        },

        computed : {
            model(){
                return this.$data.store.tabs.filter(function (data) {
                    return data.id == 'sections' ? data : false;
                })[0]
            },

            /*  shortcodes(){
             //return this.getPreview();

             return this.model.contents.map(function (m, i) {

             console.log(m);

             m.attributes['__index'] = i;

             return this.getShortCode(m.tag, m.attributes, m.contents);
             }.bind(this)).join('');

             }*/
        },

        created(){
            //this.getPreview();
        },

        methods : {
            getPreview(){

                console.log(this.shortcodes);

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
