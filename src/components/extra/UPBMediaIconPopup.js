import store from "../../store";

export default {
    name : 'upb-media-icon-popup',

    props : {
        title     : {
            type    : String,
            default : 'Icons'
        },
        button    : {
            type    : String,
            default : 'Add Icon'
        },
        providers : {
            type     : Array,
            required : true
        },

        columns : {
            type    : Number,
            default : 8
        }
    },

    data(){
        return {

            l10n : store.l10n,

            queuedIcons      : [],
            selected         : {},
            selectedProvider : {},
            iconProviders    : [],
            isLoading        : false,
            searchIcon       : '',

            start : 0,
            limit : 160,
            total : 0
        }
    },

    watch : {
        searchIcon(value){
            this.searchStringWatch();
        }
    },

    computed : {

        mediaFrameClass(){
            let frameClass = ['media-frame', 'mode-select', 'wp-core-ui', 'hide-router'];
            if (this.providers.length < 2) {
                frameClass.push('hide-menu');
            }
            return frameClass.join(' ');
        },

        icons(){
            let query = this.searchIcon.toLowerCase().trim();

            //if (query) {
            //    return this.queuedIcons.filter((icon, key) => {
            //        return new RegExp(query, 'gui').test(icon.name.toLowerCase().trim())
            //    })
            //}
            //else {
            return this.queuedIcons;
            //}
        }
    },

    created(){
        this.defaultProvider();
    },

    mounted(){
        this.loadMoreOnScroll();
    },

    methods : {

        defaultProvider(){

            this.iconProviders = this.providers.map((provider, index) => {
                // O index is active one
                provider.active = index == 0;
                return provider;
            });

            this.setSelectedProvider();

        },

        activeProvider(id){
            this.iconProviders = this.providers.map(provider => {
                provider.active = provider.id == id;
                return provider;
            });
            this.setSelectedProvider();
        },

        setSelectedProvider(){
            this.selectedProvider = this.iconProviders.filter(provider => provider.active).pop();

            this.start       = 0;
            this.total       = 0;
            this.queuedIcons = [];
            this.fetchIcons();
        },

        searchStringWatch : _.debounce(function () {

            this.start       = 0;
            this.total       = 0;
            this.queuedIcons = [];

            this.fetchIcons();
        }, 400),

        loadMoreIcons : _.debounce(function () {
            this.fetchIcons();
        }, 400),

        loadMoreOnScroll(){
            let element = this.$el.querySelector('#upb-attachments');

            element.addEventListener('scroll', () => {

                let fullHeight      = element.scrollHeight;
                let height          = element.clientHeight;
                let top             = element.scrollTop;
                let offset          = 100; // start loading before 100px
                let alreadyScrolled = height + top + offset;

                if (alreadyScrolled > fullHeight && this.total > this.queuedIcons.length) {
                    this.loadMoreIcons();
                }
            });
        },

        fetchIcons(){

            this.isLoading = true;
            store.wpAjax('_upb_icon_popup_load',
                {
                    provider : this.selectedProvider.id,
                    start    : this.start,
                    limit    : this.limit,
                    total    : this.total,
                    search   : this.searchIcon.toLowerCase().trim()
                },
                iconObject => {
                    this.isLoading = false;

                    if (this.searchIcon.toLowerCase().trim()) {
                        this.queuedIcons = _.uniq(iconObject.icons);
                    }
                    else {
                        this.queuedIcons = _.uniq(this.queuedIcons.concat(iconObject.icons));
                    }

                    this.start = this.queuedIcons.length;
                    this.total = parseInt(iconObject.total);
                },
                error => {
                    this.isLoading = false;

                    console.log(error);
                    console.info(`%c Error on Icon fetch. Use filter "upb_icon_popup_icons" to add or modify icons list.`, 'color:red; font-size:18px');

                },
                {
                    cache : true,
                    type  : 'GET'
                });
        },

        isSelected(){
            return !_.isEmpty(this.selected);
        },

        deSelectIcon(){
            Vue.set(this, 'selected', {});
        },

        chooseIcon(icon){
            Vue.set(this, 'selected', {
                id       : icon.id,
                name     : icon.name,
                provider : this.selectedProvider.title
            });
        },

        selectedIconClass(icon){

            let className = ['attachment', 'save-ready'];

            if (this.selected.id == icon.id) {

                className.push('selected');
                className.push('details');
            }
            return className.join(' ')
        },

        onCloseEvent(){
            this.$emit('close');
        },

        onInsertEvent(){
            this.$emit('insert', this.selected);
            this.onCloseEvent();
        }
    }
}