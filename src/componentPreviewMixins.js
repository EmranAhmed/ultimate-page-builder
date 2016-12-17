import store from './store'

export default{

    section : {},

    row : {
        methods : {
            rowClass(){
                return store.grid.groupClass;
            }
        }
    },

    column : {

        computed : {
            hasContents(){
                return this.model.contents.length > 0 ? true : false;
            }
        },

        created(){

            this.$watch('model.contents', function (newVal, oldVal) {
                this.addClass();
            })

            this.$watch('model.attributes', function (newVal, oldVal) {
                this.addClass();
            }, {deep : true})

            //

        },

        mounted(){
            this.addClass();
        },

        methods : {

            addClass(){

                // Generated Grid Classes
                let gridClass = this.columnClass();

                //let prefixClassLength = store.grid.prefixClass.length + store.grid.separator.length;
                let prefixClass = `${store.grid.prefixClass}${store.grid.separator}`;

                // Take Existing Grid Class
                let removableClass = [];
                this.$el.classList.forEach(className=> {
                    if (className.substr(0, prefixClass.length) === prefixClass) {
                        removableClass.push(className)
                    }
                });

                // Remove Existing Grid Class
                removableClass.map(className=>this.$el.classList.remove(className));

                // New Grid Added
                gridClass.map(className=>this.$el.classList.add(className));

                // No Content Class Added
                if (this.hasContents) {
                    this.$el.classList.remove('upb-preview-element-no-contents')
                }
                else {
                    this.$el.classList.add('upb-preview-element-no-contents')
                }
            },

            columnClass(){

                let grid = store.grid.devices.map((device)=> {
                    let gridValue = this.model.attributes[device.id].trim();

                    if (gridValue) {
                        let col = parseInt(gridValue.split(':')[0]);
                        let t   = parseInt(gridValue.split(':')[1]);
                        let g   = Math.round((store.grid.totalGrid / t) * col)
                        return `${store.grid.prefixClass}${store.grid.separator}${device.id}${store.grid.separator}${g}`
                    }
                    else {
                        return '';
                    }
                });

                return _.compact(grid);

            }
        }
    }
}