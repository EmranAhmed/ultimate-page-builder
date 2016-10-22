<template>
    <div id="app">

        <component v-for="(content, index) in contents" :parent="contents" :index="index" :model="content" :is="content.shortcode"></component>

        <section class="add-new-row">
            <div class="row">
                <div class="col-sm-12">
                    <div class="column-drop-zone">
                        <div class="text-center">
                            <button class="btn btn-danger" @click="addNewRow()">Add New Row</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--<pre style="max-height: 300px; overflow: auto">{{ contents }}</pre>-->
    </div>
</template>
<style src="./scss/app.scss" lang="sass"></style>
<script>
    import Vue from 'vue';
    import Row from './components/Row.vue';
    import Column from './components/Column.vue';

    Vue.component('Row', Row);
    Vue.component('Column', Column);

    export default {
        props    : ['parent', 'index', 'model'],
        computed : {
            contents () {

            }
        },

        methods : {
            addNewRow(){
                this.$store.dispatch('add_row'); // Call add_row Action
            }
        }
    }
</script>
