<template>
    <div @dragend="moveStop(model)" @dragstart="dragStart($event, model)" :class="[grid_class, 'grid-column', 'has-toolbar']">

        <div class="toolbar">
            <div class="text-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs" @mouseup="moveStop(model)" @mousedown="moveStart(model)" aria-label="Move">
                        <i class="fa fa-arrows" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-xs" @click="increaseColumn(model)" aria-label="Decrease Column">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-xs" @click="decreaseColumn(model)" aria-label="Increase Column">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-xs" @click="deleteColumn(parent, index)" aria-label="Delete">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>

                </div>
            </div>
        </div>

        <slot>
            <component v-for="(content, index) in model.contents" :parent="model.contents" :index="index" :model="content" :is="content.shortcode">
                <div class="element-drop-zone" v-html="content.contents"></div>
            </component>
        </slot>
    </div>
</template>
<style src="../scss/column.scss" lang="sass"></style>
<script>

    export default {

        name : 'Column',

        props : ['parent', 'index', 'model'],

        computed : {
            contents(){
                return store.getters.user;
            },
            grid_class(){
                return this.model.attrs.responsive.map(function (args) {
                    let key  = Object.keys(args)[0];
                    let grid = args[key].grid;

                    if (args[key].enable) {
                        return `col-${key}-${grid}`;
                    }
                }).join(' ').trim();

            },
        },

        methods : {

            moveStart(model){
                this.$el.setAttribute('draggable', true);
            },

            moveStop(model){

                //console.log('DRAG END');
                this.$el.removeAttribute('draggable');

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
                //console.log(this.$root.$options.data());

                //
            },
            addElement(model){
                //console.log('MOVING')
                this.$store.dispatch('add_element', model);
            },
            increaseColumn(model){

                // this.$parent.$options.methods.someParentMethod(data)

                //console.log( this.$parent.$options.data().fixWidthIcon );
                //console.log( this.$parent.$options.methods.getChildren() );
                //console.log(this.$parent.model);
                this.$store.dispatch('increase_column', model);
            },

            decreaseColumn(model){
                this.$store.dispatch('decrease_column', model);
            },

            deleteColumn(parent, index){
                if (confirm('Are you sure to remove?')) {
                    this.$store.dispatch('delete_column', {parent, index});
                }
            }

        }
    }
</script>
