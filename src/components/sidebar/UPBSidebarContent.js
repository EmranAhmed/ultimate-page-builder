import store from '../../store'

export default {
    name  : 'upb-sidebar-contents',
    props : ['index', 'model'],
    data(){
        return {

            item : {},

            l10n       : store.l10n,
            breadcrumb : store.breadcrumb,

            showHelp    : false,
            showSearch  : false,
            searchQuery : '',
            sortable    : {
                handle      : '> .tools > .handle',
                placeholder : "upb-sort-placeholder",
                axis        : 'y'
            },

            transitionName : 'slide-left'
        }
    },

    watch : {
        $route (to, from) {
            const toDepth       = to.path.split('/').length;
            const fromDepth     = from.path.split('/').length;
            this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';

            // Close Sub Panel If opened
            store.closeSubPanel();
            this.item = this.getTabContent();

        }
    },

    created() {
        this.item = this.getTabContent();
    },

    methods : {

        getItem(){

            let item = _.findWhere(this.model, {id : this.$route.params.tab});

            let sectionId = this.$route.params['sectionId'];
            let rowId     = this.$route.params['rowId'];
            let columnId  = this.$route.params['columnId'];

            let type = (this.$route.params['type'] == 'settings') ? '_upb_settings' : this.$route.params['type'].trim();

            // Get Element

            // Get Elements

            // Get Column
            if (this.has('sectionId') && this.has('rowId') && this.has('columnId')) {
                // this.item = item.contents[this.$route.params['sectionId']].contents[this.$route.params['rowId']].contents[this.$route.params['columnId']]
                this.item = item.contents[sectionId].contents[rowId][type][columnId];
            }

            // Get Row
            else if (this.has('sectionId') && this.has('rowId') && !this.has('columnId')) {
                //this.item = item.contents[this.$route.params['sectionId']].contents[this.$route.params['rowId']]

                this.item = item.contents[sectionId][type][rowId];
            }

            // Get Section
            else if (this.has('sectionId') && !this.has('rowId') && !this.has('columnId')) {
                this.item = item[type][sectionId];
            }
        },

        getTabContent(){
            return _.findWhere(this.model, {id : this.$route.params.tab});
        },

        has(keyName){
            return typeof this.$route.params[keyName] == 'number';
        }
    }
}
