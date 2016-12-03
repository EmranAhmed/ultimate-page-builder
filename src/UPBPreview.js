import store from './store'

import previewMixins from './previewMixins';

store.getAllUPBElements((elements) => {

    for (let element in elements) {

        let template        = elements[element]._upb_options.preview.template;
        let component       = `upb-${element}`;
        let componentMixins = elements[element]._upb_options.preview.mixins;

        Vue.component(component, function (resolve, reject) {

            store.getShortCodePreviewTemplate(template, function (templateData) {

                resolve({
                    name     : component,
                    template : templateData,
                    mixins   : [previewMixins, componentMixins]
                });

            })
        });
    }

}, _=> {});

import Vue from 'vue';
export default {
    name     : 'upb-preview',
    data(){
        return {}
    },
    computed : {
        model(){
            return this.$root.$data.store.tabs.filter(function (data) {
                return data.id == 'sections' ? data : false;
            })[0]
        }
    },

    updated(){
        this.model.contents.map((m, i) => {
            m.attributes['_keyIndex'] = i;
            this.addIndexAttribute(m.attributes, m.contents);
        });
    },

    created(){
        this.model.contents.map((m, i) => {
            m.attributes['_keyIndex'] = i;
            this.addIndexAttribute(m.attributes, m.contents);
        });
    },

    methods : {
        addIndexAttribute(attrs, contents){
            if (Array.isArray(contents)) {
                contents.map((m, i) => {
                    m.attributes['_keyIndex'] = `${attrs._keyIndex}/${i}`;
                    this.addIndexAttribute(m.attributes, m.contents);
                })
            }
        }
    }
}