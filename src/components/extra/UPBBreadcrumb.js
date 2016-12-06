import store from '../../store';
import extend from 'extend';

export default {
    name  : 'upb-breadcrumb',
    props : ['model'],
    data(){
        return {
            l10n       : store.l10n,
            breadcrumb : [],
            contents   : {},
            link       : '',
            sections   : {}
        }
    },

    created(){

        let params    = this.$route.params;
        this.sections = extend(true, {}, store.tabs.filter((t)=> {
            return t.id == params.tab;
        }).pop());

        let path = this.$route.path.split('/');

        //let sliced = path.slice(2, path.length - 1); // 0
        let sliced = path.slice(2, -2); // 0

        console.log(sliced);
        // console.log(path);

        // 0 tab
        // 1 = section
        // 2 = row

        // Sections Added
        this.link = `/${this.sections.id}`;
        this.breadcrumb.push({title : this.sections.title, link : `/${this.sections.id}`});

        sliced.forEach((value, index) => {
            this.addToBreadcrumb(value);
        });

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

        addToBreadcrumb(index){

            let params   = this.$route.params;
            this.link += `/${index}`;
            let contents = _.isEmpty(this.contents) ? this.sections.contents[index] : this.contents[index];

            this.contents = extend(true, {}, contents);

            let link  = `${this.link}/${params.type}`;
            let title = this.contents.attributes['title'] ? this.contents.attributes.title : this.contents._upb_options.element.name;

            this.breadcrumb.push({title : title, link : link})

        }
    }
}