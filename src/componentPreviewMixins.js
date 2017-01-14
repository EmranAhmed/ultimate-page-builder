import store from './store'

export default{

    'upb-row' : {
        computed : {
            rowGroupClass(){
                return store.grid.groupClass;
            }
        },

        methods : {

            containerClass(){

                let cssClasses = [];

                cssClasses.push(this.model.attributes.container);

                if (!_.isUndefined(this.model.attributes['element_class'])) {
                    cssClasses.push(this.model.attributes.element_class);
                }

                if (this.hiddenDeviceClasses) {
                    cssClasses.push(this.hiddenDeviceClasses);
                }

                return cssClasses.join(' ');
            },

            addClass(extra = false){

                let cssClasses = [];

                cssClasses.push(`upb-preview-element`);

                cssClasses.push(`${this.model.tag}-preview`);

                if (extra && _.isString(extra)) {
                    cssClasses.push(extra);
                }

                if (extra && _.isArray(extra)) {
                    cssClasses.push(...extra);
                }

                if (this.model._upb_options.hasMiniToolbar) {
                    cssClasses.push(`upb-has-mini-toolbar`);
                }

                cssClasses.push(this.rowGroupClass);

                if (!this.model._upb_options.core) {
                    cssClasses.push(`upb-preview-element-non-core`);
                }

                if (_.isArray(this.model.contents)) {
                    cssClasses.push(`upb-preview-element-type-container`);
                }

                return cssClasses.join(' ');
            }
        }
    },

    'upb-column' : {

        methods : {

            addClass(extra = false){

                let cssClasses = [];

                cssClasses.push(`upb-preview-element`);

                cssClasses.push(`${this.model.tag}-preview`);

                if (extra && _.isString(extra)) {
                    cssClasses.push(extra);
                }

                if (extra && _.isArray(extra)) {
                    cssClasses.push(...extra);
                }

                if (this.model._upb_options.hasMiniToolbar) {
                    cssClasses.push(`upb-has-mini-toolbar`);
                }

                if (!_.isUndefined(this.model.attributes['element_class'])) {
                    cssClasses.push(this.model.attributes.element_class);
                }

                cssClasses.push(...this.generateColumnClass());

                cssClasses.push(this.hiddenDeviceClasses);

                // No Content Class Added
                if (!this.hasContents) {
                    cssClasses.push(`upb-preview-element-no-contents`);
                }

                if (!this.model._upb_options.core) {
                    cssClasses.push(`upb-preview-element-non-core`);
                }

                if (_.isArray(this.model.contents)) {
                    cssClasses.push(`upb-preview-element-type-container`);
                }

                return cssClasses.join(' ');
            },

            generateColumnClass(){

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
                grid.unshift(store.grid.allGridClass);
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
}