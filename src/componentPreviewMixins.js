import store from './store'

export default{

    'upb-section' : {
        /*created(){
         this.$watch('model.contents', function (newVal, oldVal) {
         this.addClass();
         })
         },

         mounted(){
         this.addClass();
         },*/

        /*methods : {
         addClass(){
         // No Content Class Added
         if (this.hasContents) {
         this.$el.classList.remove('upb-preview-element-no-contents')
         }
         else {
         this.$el.classList.add('upb-preview-element-no-contents')
         }
         }
         }*/
    },

    'upb-row' : {
        computed : {
            containerClass(){
                return this.model.attributes.container;
            },

            rowClass(){
                return store.grid.groupClass;
            }
        },

        /*created(){
         this.$watch('model.contents', function (newVal, oldVal) {
         this.addClass();
         })
         },

         mounted(){
         this.addClass();
         },*/

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

                if (!this.model._upb_options.core) {
                    this.$el.classList.add('upb-preview-element-non-core')
                }

                if (_.isArray(this.model.contents)) {
                    this.$el.classList.add('upb-preview-element-type-container')
                }
            }
        }
    },

    'upb-column' : {

        /*created(){

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
         },*/

        methods : {

            isElementRegistered(tag){
                return store.elements.includes(tag);
            },

            addClass(){

                // Generated Grid Classes
                let gridClass = this.columnClass();

                //let prefixClassLength = store.grid.prefixClass.length + store.grid.separator.length;
                let prefixClass = `${store.grid.prefixClass}${store.grid.separator}`;

                // Take Existing Grid Class
                let removableClass = [];

                // or [...this.$el.classList].map()
                Array.from(this.$el.classList, className=> {
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

                if (!this.model._upb_options.core) {
                    this.$el.classList.add('upb-preview-element-non-core')
                }

                if (_.isArray(this.model.contents)) {
                    this.$el.classList.add('upb-preview-element-type-container')
                }
            },

            columnClass(){

                let grid = store.grid.devices.map((device)=> {
                    let gridValue = this.model.attributes[device.id].trim();

                    if (gridValue) {
                        let [col, t] = gridValue.split(':');
                        //let t   = parseInt(gridValue.split(':')[1]);
                        let g = Math.round((store.grid.totalGrid / parseInt(t)) * parseInt(col));

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
    },

    'contact-form-7' : {

        created(){

            this.$watch('model.attributes', (attributes, oldVal)=> {
                this.getForm(attributes.id, attributes.title);
            }, {deep : true});

            if (this.model.attributes.id) {
                this.getForm(this.model.attributes.id, this.model.attributes.title);
            }
        },

        methods : {
            getForm(id, title){
                store.wpAjax('_upb_contact_form7_preview', {
                    id,
                    title
                }, data=> {
                    this.$el.querySelector('.ajax-result').innerHTML = data
                });
            }
        }
    }
}