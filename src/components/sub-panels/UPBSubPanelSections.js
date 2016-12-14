import store from '../../store'
import extend from 'extend'
import {sprintf} from 'sprintf-js';

export default {
    name  : 'upb-sub-panel-sections',
    props : ['index', 'model'],
    data(){
        return {
            l10n             : store.l10n,
            searchQuery      : '',
            showTextarea     : false,
            textareaContents : '',
            item             : []
        }
    },

    computed : {
        contents(){

            let query = this.searchQuery.toLowerCase().trim();
            if (query) {
                return this.item.filter((data) => new RegExp(query, 'gui').test(data.attributes.title.toLowerCase().trim()))
            }
            else {
                return this.item;
            }
        }
    },

    created(){
        this.loadContents();
    },

    methods : {

        loadContents(){
            store.getSavedSections((contents) => {
                this.$nextTick(function () {
                    Vue.set(this, 'item', contents);
                });
            }, (data) => {
                console.log(data);
            })
        },

        toggleTextarea(){

            this.textareaContents = '';
            this.showTextarea     = !this.showTextarea;

        },

        deleteSection(index){
            this.item.splice(index, 1);

            store.saveAllSectionToOption(this.item, (data) => {
                this.$toast.success(this.l10n.sectionDeleted);
            }, (data)=> {

            });

        },

        addSection(index){

            let item = extend(true, {}, this.item[index]);

            // console.log(item);

            this.model.filter((tab) => {
                if (tab.id == 'sections') {
                    tab.contents.push(item);
                    this.$toast.success(sprintf(this.l10n.sectionAdded, item.attributes.title));

                    tab.contents[tab.contents.length - 1]._upb_options.focus = true
                }
            });

            store.stateChanged();
            store.closeSubPanel();
        }
    }
}