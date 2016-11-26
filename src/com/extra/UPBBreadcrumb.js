import store from '../../store'

export default {
    name : 'upb-breadcrumb',
    data(){
        return {
            l10n       : store.l10n,
            breadcrumb : []
        }
    },

    created(){

        let params = this.$route.params;
        let tab    = store.tabs.filter((t)=> {
            if (t.id == params.tab) {
                return t;
            }
        }).pop();

        // this.$router.replace('/sections');
        //this.breadcrumb.push({title : tab.title, link : `/${tab.id}`})

        let path = this.$route.path.split('/');

        // title, link

        let sliced = path.slice(2, path.length - 1); // 0,0

        console.log(sliced);

        // 0 = tabs
        // 1 = section
        // 2 = rows

        sliced.forEach((value, index) => {

                if (index == 0) { // sections, we donot add link on 1st one
                    //this.breadcrumb.push({title : tab.title, link : `/${tab.id}`})
                    this.breadcrumb.push({title : tab.title, link : false})
                }
                else {

                    //    let i = tab.contents[value];

                }

                // this.breadcrumb.push({title : i.attributes.title, link : `/${tab.id}/${value}/${params.type}`})

                //console.log(index);
            }
        );

    },

    methods : {

        goTo(link){
            if (link) {
                this.$router.replace(link);
            }
        },

        _addToBreadcrumb(contents){


            // this.breadcrumb.push({title : i.attributes.title, link : `/${tab.id}/${value}/${params.type}`})

        }
    }
}