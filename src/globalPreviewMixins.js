import store from './store'

export default{
    props : {
        index : {
            type : Number
        },

        model : {
            type : Object
        }
    },

    data(){
        return {
            l10n : store.l10n
        }
    },

    created(){

        this.$watch('model.contents', function (newVal, oldVal) {
            this.addClass();
        });

        this.$watch('model.attributes', function (newVal, oldVal) {
            this.addClass();
        }, {deep : true});

        //
    },

    mounted(){
        this.addClass();
    },

    computed : {
        hasContents(){
            if (!_.isUndefined(this.model['contents'])) {
                return this.model.contents.length > 0;
            }
        },
        $router(){
            return this.$root.$data.store.panel._router;
        },
        $route(){
            return this.$root.$data.store.panel._route;
        }
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

            if (!this.model._upb_options.core) {
                this.$el.classList.add('upb-preview-element-non-core')
            }

            if (_.isArray(this.model.contents)) {
                this.$el.classList.add('upb-preview-element-type-container')
            }

            // console.log(this.model._upb_options.core, this.model._upb_options.element.nested);
        },

        openElementsPanel(){
            this.$router.replace(`/elements`);
        },

        // Alias of openElementItemsPanel
        openElementsItemPanel(path){
            this.openElementItemsPanel(path);
        },
        openElementItemsPanel(path){
            this.$router.replace(`/sections/${path}/contents`);
        }
    }
}