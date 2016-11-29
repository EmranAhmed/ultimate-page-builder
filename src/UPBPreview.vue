<template>
    <div id="upb-preview" class="upb-wrapper">


        <upb-section v-for="contents in model.contents" :model="contents"></upb-section>


    </div>
</template>
<style src="./scss/upb-preview.scss" lang="sass"></style>
<script>

    // wp.shortcode.string({tag:'gallery', attrs:{a:1}})
    // wp.shortcode.replace('gallery', 'hello [gallery]', function(shortcode){ return 'xxxxx' })

    Vue.component('upb-section', {
        //template : '<button>{{ attributes }}</button>',
        template : '#hello-world-template',
        props    : ['model'],
        watch    : {
            shortcode(n){
                console.log(n)
            }
        },
        computed : {
            shortcode(){
                return wp.shortcode.string({
                    tag     : this.model.tag,
                    attrs   : this.model.attributes,
                    content : this.shortcodes(this.model.contents),
                })
            }
        },

        methods : {
            shortcodes(contents){

                if (Array.isArray(contents)) {

                    return contents.map( (c) => {

                        return wp.shortcode.string({
                            tag     : c.tag,
                            attrs   : c.attributes,
                            content : this.shortcodes(c.contents),
                        })

                    })
                }
                else{
                    return contents;
                }

            }
        }
    });

    import Vue from 'vue';

    export default {
        name : 'upb-preview',
        data(){
            return this.$root.$data
        },

        computed : {
            model(){
                return this.$data.store.tabs.filter(function (data) {
                    return data.id == 'sections' ? data : false;
                })[0]
            }
        },

        created(){

            console.log(this.model.contents)

        }
    }
</script>
