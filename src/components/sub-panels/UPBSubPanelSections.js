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
                return this.model.filter((data) => new RegExp(query, 'gui').test(model.title.toLowerCase().trim()))
            }
            else {
                return this.model;
            }
        }
    },

    mounted(){
        this.loadContents();
    },

    methods : {

        loadContents(){

            if (this.model.length <= 0) {
                store.getSavedSections((contents) => {

                    console.log(contents);

                    this.$nextTick(function () {
                        // this.model = contents;
                    });

                }, function () {})
            }
            else {
                return this.model;
            }

        },

        toggleTextarea(){

            this.textareaContents = '';
            this.showTextarea     = !this.showTextarea;

        }
    }
}