import Vue from 'vue';

import store from './store'

import globalPreviewMixins from './globalPreviewMixins';
import componentPreviewMixins from './componentPreviewMixins';

import Droppable from './plugins/vue-droppable'

import PreviewElement from './plugins/vue-preview-element'
import UPBPreviewMiniToolbar from './components/extra/UPBPreviewMiniToolbar.vue'

Vue.component('upb-preview-mini-toolbar', UPBPreviewMiniToolbar);

Vue.use(PreviewElement);
Vue.use(Droppable);

store.getAllUPBElements((elements) => {

    // console.log(elements);

    elements.map((element)=> {

        let template           = element._upb_options.preview.template;
        let component          = `upb-${element.tag}`;
        let componentMixins    = element._upb_options.preview.mixins;
        let upbComponentMixins = _.isEmpty(componentPreviewMixins[element.tag]) ? false : componentPreviewMixins[element.tag];

        Vue.component(component, function (resolve, reject) {

            store.getShortCodePreviewTemplate(template, function (templateData) {

                resolve({
                    name     : component,
                    template : templateData,
                    mixins   : [globalPreviewMixins, upbComponentMixins, componentMixins]
                });

                store.loadPreviewAssets(element.tag, element._upb_options.assets.preview);

            })
        });
    });

}, _=> {});

export default {
    name     : 'upb-preview',
    data(){
        return {}
    },
    computed : {
        model(){
            return this.$root.$data.store.tabs.filter(function (data) {
                return data.id == 'sections' ? data : false;
            }).pop()
        },
        settings(){
            let settings = this.$root.$data.store.tabs.filter(function (data) {
                return data.id == 'settings' ? data : false;
            }).pop();
            return settings['contents'] ? settings.contents : [];
        }
    },

    updated(){
        if (this.model.contents) {
            this.addKeyIndex();
        }
        else {
            this.$nextTick(function () {
                this.addKeyIndex();
            })
        }
    },

    created(){
        this.addKeyIndex();
    },

    methods : {

        addKeyIndex(){
            this.model.contents.map((m, i) => {
                m._upb_options['_keyIndex'] = i;
                this.addIndexAttribute(m, m.attributes, m.contents);
            });
        },

        addIndexAttribute(model, attrs, contents){
            if (_.isArray(contents)) {
                contents.map((m, i) => {
                    m._upb_options['_keyIndex'] = `${model._upb_options._keyIndex}/${i}`;
                    this.addIndexAttribute(m, m.attributes, m.contents);
                })
            }
        }
    }
}