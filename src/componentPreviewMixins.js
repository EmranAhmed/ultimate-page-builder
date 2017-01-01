import store from './store'

export default{

    section : {
        created(){
            this.$watch('model.contents', function (newVal, oldVal) {
                this.addClass();
            })
        },

        mounted(){
            this.addClass();
        },

        methods : {
            addClass(){
                // No Content Class Added
                if (this.hasContents) {
                    this.$el.classList.remove('upb-preview-element-no-contents')
                }
                else {
                    this.$el.classList.add('upb-preview-element-no-contents')
                }
            }
        }
    },

    row : {
        computed : {
            containerClass(){
                return this.model.attributes.container;
            },

            rowClass(){
                return store.grid.groupClass;
            }
        },

        created(){
            this.$watch('model.contents', function (newVal, oldVal) {
                this.addClass();
            })
        },

        mounted(){
            this.addClass();
        },

        methods : {

            addClass(){

                // We Have container wrapped
                let element = this.$el.firstChild;

                // Generated Grid Classes
                let rowClass = [this.rowClass];

                // New Grid Added
                rowClass.map(className=>element.classList.add(className));

                // No Content Class Added
                if (this.hasContents) {
                    element.classList.remove('upb-preview-element-no-contents')
                }
                else {
                    element.classList.add('upb-preview-element-no-contents')
                }
            }
        }
    },

    column : {

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
                        let g   = Math.round((store.grid.totalGrid / t) * col);

                        return `${store.grid.prefixClass}${store.grid.separator}${device.id}${store.grid.separator}${g}`
                    }
                    else {
                        return '';
                    }
                });

                // added extra grid class to control gutter
                grid.unshift(store.grid.prefixClass);
                return _.compact(grid);
            },

            dropAccept(content){
                return true;
            },

            afterDrop(content, accepted = false){
                if (accepted) {
                    this.model.contents.push(content);
                    store.stateChanged();

                    this.$nextTick(function () {

                        if (_.isArray(content.contents)) {
                            this.$router.replace(`/sections/${content._upb_options._keyIndex}/contents`);
                        }

                        else if (_.isObject(content.attributes)) {
                            this.$router.replace(`/sections/${content._upb_options._keyIndex}/settings`);
                        }
                    })
                }
            }
        }
    }
}