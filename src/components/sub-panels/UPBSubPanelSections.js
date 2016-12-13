import store from '../../store'

export default {
    name : 'upb-sub-panel-sections',
    data(){
        return {
            l10n             : store.l10n,
            searchQuery      : '',
            showTextarea     : false,
            textareaContents : '',
            model            : []
        }
    },

    computed : {
        contents(){

            let query = this.searchQuery.toLowerCase().trim();
            if (query) {
                return this.model.filter((data) => new RegExp(query, 'gui').test(data.attributes.title.toLowerCase().trim()))
            }
            else {
                return this.model;
            }
        }
    },

    created(){
        this.loadContents();
    },

    methods : {

        loadContents(){

            this.$progressbar.show();
            store.getSavedSections((contents) => {

                this.$nextTick(function () {
                    Vue.set(this, 'model', contents);
                });
                this.$progressbar.hide();

            }, (data) => {
                console.log(data);
                this.$progressbar.hide();
            })

        },

        toggleTextarea(){

            this.textareaContents = '';
            this.showTextarea     = !this.showTextarea;

        },

        deleteSection(index){
            this.model.splice(index, 1);

            store.saveAllSectionToOption(this.model, (data) => {

                console.log(data);
            }, ()=> {

            });

        }
    }
}