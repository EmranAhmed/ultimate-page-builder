<template>
    <ul>


        <router-link to="/sections/0/contents" tag="li" active-class="active"><a>Section 1</a></router-link>
        <router-link to="/sections/0/settings" tag="li" active-class="active"><a>Section 1 Settings</a></router-link>

        <router-link to="/sections/1/contents" tag="li" active-class="active"><a>Section 2</a></router-link>
        <router-link to="/sections/1/settings" tag="li" active-class="active"><a>Section 2 Settings</a></router-link>


        <router-link to="/sections/0/0/contents" tag="li" active-class="active"><a>Row 1</a></router-link>
        <router-link to="/sections/0/0/settings" tag="li" active-class="active"><a>Row 1 Settings</a></router-link>

        <router-link to="/sections/0/0/0/contents" tag="li" active-class="active"><a>Column 1</a></router-link>
        <router-link to="/sections/0/0/0/settings" tag="li" active-class="active"><a>Column 1 Settings</a></router-link>


        list component

<!--
        <router-view :model="model"></router-view>
-->

    </ul>
</template>
<style>
    .slide-left-enter-active {
        width      : 300px;
        transition : margin .3s ease;
        }

    .slide-left-leave-active {
        transition : margin .3s ease;
        }

    .slide-left-enter, .slide-left-leave-active {
        margin-left : 350px;
        width       : 300px;
        opacity     : 0;
        position    : absolute;
        }

    .slide-right-enter-active {
        width      : 300px;
        transition : margin .3s ease;
        }

    .slide-right-leave-active {
        transition : margin .3s ease;
        }

    .slide-right-enter, .slide-right-leave-active {
        margin-left : -350px;
        width       : 300px;
        opacity     : 0;
        position    : absolute;
        }
</style>
<script>
    import Vue from 'vue';

    // import List from './ListView.vue'
    // import Attributes from './Attributes.vue'

    export default {
        name  : 'sections',
        props : ['model'],
        data () {
            return {
                transitionName : 'slide-left'
            }
        },
        watch : {
            $route (to, from) {

                const toDepth       = to.path.split('/').length
                const fromDepth     = from.path.split('/').length
                this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left'

                //console.log(toDepth, fromDepth)
            }
        },
        created() {

            //console.log(this.model)
            //console.log(this.$route.name)
        },
    }
</script>