<template>
    <div id="upb-preview" class="upb-wrapper">

        {{ preview }}
        {{ shortcodes }}

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
                shortcode : ''
            }
        },

        created(){

            this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

            this.$watch(`model`, function (value) {

                this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

                console.log(this.shortcode);

                // https://vuejs.org/v2/api/#vm-watch

            }.bind(this), {deep : true});

            this.$watch(`model.contents`, function (value) {

                this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

                console.log(this.shortcode);

                // https://vuejs.org/v2/api/#vm-watch

            }.bind(this));

        },

        methods : {

            getShortCode(tag, attrs, contents){
                return wp.shortcode.string({
                    tag     : tag,
                    attrs   : attrs,
                    content : this.contents(contents)
                })
            },

            contents(contents){

                if (Array.isArray(contents)) {
                    return contents.map(function (c, i) {
                        return this.getShortCode(c.tag, c.attributes, c.contents);
                    }.bind(this)).join('')
                }
                else {
                    return contents;
                }

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
                shortcode : ''
            }
        },

        created(){

            this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

            this.$watch(`model.attributes`, function (value) {

                this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

                console.log(this.shortcode);

                // https://vuejs.org/v2/api/#vm-watch

            }.bind(this), {deep : true});

            this.$watch(`model.contents`, function (value) {

                this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

                console.log(this.shortcode);

                // https://vuejs.org/v2/api/#vm-watch

            }.bind(this));

        },

        methods : {

            getShortCode(tag, attrs, contents){
                return wp.shortcode.string({
                    tag     : tag,
                    attrs   : attrs,
                    content : this.contents(contents)
                })
            },

            contents(contents){

                if (Array.isArray(contents)) {
                    return contents.map(function (c, i) {
                        return this.getShortCode(c.tag, c.attributes, c.contents);
                    }.bind(this)).join('')
                }
                else {
                    return contents;
                }

            }
        }
    });

    Vue.component('upb-column', {
        //template : '<button>{{ attributes }}</button>',
        template : '#upb-column-template',
        //render: createElement=>createElement(),
        props    : ['index', 'model'],
        data(){
            return {
                shortcode : ''
            }
        },

        created(){

            this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

            this.$watch(`model.attributes`, function (value) {

                this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

                console.log(this.shortcode);

                // https://vuejs.org/v2/api/#vm-watch

            }.bind(this), {deep : true});

            this.$watch(`model.contents`, function (value) {

                this.shortcode = this.getShortCode(this.model.tag, this.model.attributes, this.model.contents);

                console.log(this.shortcode);

                // https://vuejs.org/v2/api/#vm-watch

            }.bind(this));

        },

        methods : {

            getShortCode(tag, attrs, contents){
                return wp.shortcode.string({
                    tag     : tag,
                    attrs   : attrs,
                    content : this.contents(contents)
                })
            },

            contents(contents){

                if (Array.isArray(contents)) {
                    return contents.map(function (c, i) {
                        return this.getShortCode(c.tag, c.attributes, c.contents);
                    }.bind(this)).join('')
                }
                else {
                    return contents;
                }

            }
        }
    });

    import Vue from 'vue';

    export default {
        name : 'upb-preview',
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
