import store from '../../store';
import extend from 'extend';

export default {
    name : 'upb-breadcrumb',
    data(){
        return {
            l10n       : store.l10n,
            breadcrumb : [],
            path       : [],
            link       : ''
        }
    },

    created(){

        let sections = extend(true, {}, store.tabs.filter((t)=> {
            return t.id == this.$route.params.tab;
        }).pop());

        let sliced = this.$route.path.split('/').slice(2, -2); // trim sections and contents|settings

        this.path = this.$route.path.split('/').slice(1, -2);

        // Sections Added
        this.link = `/${sections.id}`;
        this.breadcrumb.push({title : sections.title, link : `/${sections.id}`});

        if (sliced.length > 0) {
            let unflattenPath = this.unflatten(sliced);
            this.generateBreadcrumb(sections.contents, unflattenPath);
        }
    },

    methods : {

        className(){
            return [
                `breadcrumb`,
                (this.breadcrumb.length > 1) ? 'breadcrumb-arrow' : ''
            ].join(' ')

        },

        goTo(link){
            if (link) {
                this.$router.replace(link);
            }
        },

        generateBreadcrumb(contents, path){

            let index = path[0]['index'];
            let child = path[0]['child'];
            let data  = contents[index];
            this.link += `/${index}`;

            let title = data.attributes['title'] ? data.attributes.title : data._upb_options.element.name;
            let link  = `${this.link}/${this.$route.params.type}`;

            this.breadcrumb.push({title : title, link : link});

            if (child.length > 0) {
                this.generateBreadcrumb(data.contents, child);
            }
        },

        unflatten(arr){
            let newlist = [];
            newlist.push({index : arr.shift(), child : []});
            if (arr.length > 0) {
                newlist[0].child = this.unflatten(arr)
            }
            return newlist;
        }
    }
}