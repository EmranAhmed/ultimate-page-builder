<template>
    <section
            @dragend="moveStop(model)"
            @dragstart="dragStart($event, model)"
            @dragleave="dragLeave($event)"
            @dragover="dragOver($event)"
            @drop="drop($event, model)" class="grid-row" :style-ok="model.attrs.background">
        <div :class="[model.attrs.container ? fixWidthClass : fluidWidthClass ]">
            <div class="row has-toolbar">
                <div class="col-sm-12 toolbar">
                    <div class="text-right">
                        <div class="btn-group">
                            <button @mouseup="moveStop(model)" @mousedown="moveStart(model)" type="button" class="btn btn-default btn-xs" aria-label="Move">
                                <i class="fa fa-arrows" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" @click="addNewColumn(model)" aria-label="Add Column">
                                <i class="fa fa-columns" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" @click="toggleContainer(model)" aria-label="Toggle Container">
                                <i :class="[hasContainer ? fixWidthIcon : fluidWidthIcon]" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-xs" @click="deleteRow(parent, index)" aria-label="Delete">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <slot v-if="model.contents.length">
                    <component v-for="(content, index) in model.contents" :parent="model.contents" :index="index" :model="content" :is="content.shortcode">
                        <div class="element-drop-zone" v-html="content.contents"></div>
                    </component>
                </slot>

                <div v-else><p class="text-center">No Column</p></div>


            </div>
        </div>
    </section>
</template>
<style src="../scss/row.scss" lang="sass"></style>
<script>


    export default {

        name : 'Row',

        props : ['parent', 'index', 'model'],

        data() {
            return {
                fixWidthIcon    : 'fa fa-object-group',
                fluidWidthIcon  : 'fa fa-object-ungroup',
                fixWidthClass   : 'container',
                fluidWidthClass : 'container-fluid'
            }
        },

        computed : {
            hasContainer(){
                return this.model.attrs.container;
            }
        },

        methods : {

            moveStart(model){
                this.$el.setAttribute('draggable', true);
            },

            moveStop(model){

                //console.log('DRAG END');
                this.$el.removeAttribute('draggable');

            },

            dragLeave(e){
                this.$el.classList.remove('dropzone');
            },

            dragEnter(e){
                return true;
            },

            dragOver(e){

                this.$el.classList.add('dropzone');
                // e.dataTransfer.dropEffect = "move";
                e.preventDefault();

                //console.log(e.target);

                return true;
            },

            dragStart(e, model){
                // console.log(e, model);

                // console.log(this.parent[this.index]);

                // this.$store.dispatch('drag_from', this.$parent.model);

                // let data = {index : this.index, parent : this.parent, model : this.model}
                e.dataTransfer.setData('Text', JSON.stringify(model));
                e.dataTransfer.effectAllowed = 'move';

                // set a reference of old object
                this.$root.$options.data().from = this.$parent.model;
                this.$root.$options.data().id   = this.index;
                console.log(this.$parent.model);

                //
            },

            drop(e, model){

                this.$el.classList.remove('dropzone');

                let data = e.dataTransfer.getData('Text');

                //console.log(data);
               // console.log(this.$root.$options.data());

                return;
                // get reference for old object

                this.$store.dispatch('sort_column', {
                    row    : model,
                    column : JSON.parse(data),
                    from   : this.$root.$options.data().from,
                    id     : this.$root.$options.data().id
                });

                // re-set reference of old object
                this.$root.$options.data().from = {};
                this.$root.$options.data().id   = undefined;
            },

            toggleContainer(model){
                this.$store.dispatch('row_toggle_container', model);
            },

            deleteRow(parent, index){
                if (confirm('Are you sure to remove?')) {
                    this.$store.dispatch('delete_row', {parent, index});
                }
            },

            addNewColumn(model){
                this.$store.dispatch('add_column', model);
            }
        }
    }
</script>
