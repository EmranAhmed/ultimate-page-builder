import Vue from 'vue';
import store from './store'
import globalPreviewMixins from './globalPreviewMixins';
import componentPreviewMixins from './componentPreviewMixins';
import Droppable from './plugins/vue-droppable'
Vue.use(Droppable);

import PreviewElement from './plugins/vue-preview-element'
Vue.use(PreviewElement);

import UPBPreviewMiniToolbar from './components/extra/UPBPreviewMiniToolbar.vue'

Vue.component('upb-preview-mini-toolbar', UPBPreviewMiniToolbar);

import UIDroppable from './plugins/vue-ui-droppable'
Vue.use(UIDroppable);

import UIDraggable from './plugins/vue-ui-draggable'
Vue.use(UIDraggable);

//import ElementSortable from './plugins/vue-element-sortable'
//Vue.use(ElementSortable);

store.getAllUPBElements(elements => {

    elements.map(element=> {

        if (element._upb_options.previews && ( _.isArray(element._upb_options.previews) || _.isObject(element._upb_options.previews) )) {

            let previews = _.isObject(element._upb_options.previews) ? _.values(element._upb_options.previews) : element._upb_options.previews;

            previews.map(el=> {

                let template           = el.template;
                //let component          = `upb-${element.tag}`;
                let component          = el.component;
                let componentMixins    = el.mixins;
                //let upbComponentMixins = _.isEmpty(componentPreviewMixins[element.tag]) ? false : componentPreviewMixins[element.tag];
                let upbComponentMixins = _.isEmpty(componentPreviewMixins[template]) ? false : componentPreviewMixins[template];

                Vue.component(component, function (resolve, reject) {

                    store.getShortCodePreviewTemplate(template, function (templateData) {

                        resolve({
                            name     : component,
                            template : templateData,
                            mixins   : [globalPreviewMixins, upbComponentMixins, componentMixins],

                        });
                    })
                });
            });
        }
        //else {
        let template           = element._upb_options.preview.template;
        //let component          = `upb-${element.tag}`;
        let component          = element._upb_options.preview.component;
        let componentMixins    = element._upb_options.preview.mixins;
        //let upbComponentMixins = _.isEmpty(componentPreviewMixins[element.tag]) ? false : componentPreviewMixins[element.tag];
        let upbComponentMixins = _.isEmpty(componentPreviewMixins[template]) ? false : componentPreviewMixins[template];

        Vue.component(component, function (resolve, reject) {

            store.getShortCodePreviewTemplate(template, function (templateData) {

                resolve({
                    name     : component,
                    template : templateData,
                    mixins   : [globalPreviewMixins, upbComponentMixins, componentMixins]
                });
            })
        });
        //}
    });

}, _=> {});

export default {
    name     : 'upb-preview',
    data(){
        return {}
    },
    computed : {
        model(){
            return store.getContentsOfTab('sections').pop();
        },
        settings(){
            let settings = store.getContentsOfTab('settings').pop();
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

        this.$watch('model.contents', _=> {
            this.addKeyIndex();
        }, {deep : true});
    },

    methods : {

        addKeyIndex(){
            this.model.contents.map((m, i) => {
                m._upb_options['focus']     = false;
                m._upb_options['_keyIndex'] = i;
                this.addIndexAttribute(m, m.attributes, m.contents);
            });
        },

        addIndexAttribute(model, attrs, contents){
            if (_.isArray(contents)) {
                contents.map((m, i) => {
                    if (store.isElementRegistered(m.tag)) {
                        m._upb_options['focus']     = false;
                        m._upb_options['_keyIndex'] = `${model._upb_options._keyIndex}/${i}`;
                        this.addIndexAttribute(m, m.attributes, m.contents);
                    }
                })
            }
        }
    }
}