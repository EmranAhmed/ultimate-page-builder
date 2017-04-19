import store from './store'

export default{

    'upb-row' : {
        computed : {
            rowGroupClass(){
                return store.grid.groupClass;
            },
            containerClass(){
                let cssClasses = [];

                cssClasses.push(this.model.attributes.container);

                if (this.elementClass) {
                    cssClasses.push(this.elementClass);
                }

                if (this.deviceHiddenClasses) {
                    cssClasses.push(this.deviceHiddenClasses);
                }

                return cssClasses;
            }
        }
    },

    'upb-column' : {

        computed : {
            generatedColumnClass(){

                let grid = store.grid.devices.map((device)=> {
                    let gridValue = this.model.attributes[device.id].trim();

                    if (gridValue) {
                        let [col, t] = gridValue.split(':');

                        let g = Math.round((store.grid.totalGrid / parseInt(t)) * parseInt(col));

                        if (_.isUndefined(device.class)) {
                            return `${store.grid.prefixClass}${store.grid.separator}${device.id}${store.grid.separator}${g}`
                        }
                        else {
                            return `${device.class}${g}`
                        }
                    }
                    else {
                        return '';
                    }
                });

                // added extra grid class to control gutter
                grid.unshift(store.grid.allGridClass);
                return _.compact(grid);
            }
        },

        methods : {

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