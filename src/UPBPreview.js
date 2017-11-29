import Vue from "vue";
import store from "./store";
import { sprintf } from "sprintf-js";

import globalPreviewMixins from "./globalPreviewMixins";
import componentPreviewMixins from "./componentPreviewMixins";
import Droppable from "./plugins/vue-droppable";
import PreviewElement from "./plugins/vue-preview-element";
import UIDroppable from "./plugins/vue-ui-droppable";
import UIDraggable from "./plugins/vue-ui-draggable";

Vue.component('upb-preview-mini-toolbar', () => import(/* webpackChunkName: "upb-preview-mini-toolbar" */ './components/extra/UPBPreviewMiniToolbar.vue'));

Vue.use(Droppable);

Vue.use(PreviewElement);

Vue.use(UIDroppable);

Vue.use(UIDraggable);

store.getAllUPBElements(elements => {

    elements.map(element => {

        if (element._upb_options.previews && ( _.isArray(element._upb_options.previews) || _.isObject(element._upb_options.previews) )) {

            let previews = _.isObject(element._upb_options.previews) ? _.values(element._upb_options.previews) : element._upb_options.previews;

            previews.map(el => {

                let template           = el.template;
                let component          = el.component;
                let componentMixins    = el.mixins;
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
        let componentMixins    = JSON.parse(element._upb_options.preview.mixins);
        //let upbComponentMixins = _.isEmpty(componentPreviewMixins[element.tag]) ? false : componentPreviewMixins[element.tag];
        let upbComponentMixins = (typeof componentPreviewMixins[template] === 'undefined') ? {} : componentPreviewMixins[template];

        Vue.component(component, function (resolve, reject) {
            store.getShortCodePreviewTemplate(template, function (templateData) {

                if (_.isEmpty(templateData)) {
                    console.info(`%c "${element.tag}" preview file "previews/${template}.php" is not available or empty.`, 'color:red; font-size:18px')
                }
                resolve({
                    name     : component,
                    template : templateData || `<div style="color: red">"${element.tag}" preview file "previews/${template}.php" is not available or empty.</div>`,
                    mixins   : [globalPreviewMixins, upbComponentMixins, componentMixins]
                });
            })
        });
        //}
    });

}, () => {});

export default {
    name     : 'upb-preview',
    data() {
        return {}
    },
    computed : {
        model() {
            return store.getContentsOfTab('sections').pop();
        },
        settings() {
            let settings = store.getContentsOfTab('settings').pop();
            return settings['contents'] ? settings.contents : [];
        }
    },

    updated() {
        if (this.model.contents) {
            this.addKeyIndex();
        }
        else {
            this.$nextTick(function () {
                this.addKeyIndex();
            })
        }
    },

    created() {

        this.addKeyIndex();

        /*this.$watch('model.contents', _=> {
         // ELEMENTS POSITION changes then create element
         //    this.addKeyIndex();
         }, {deep : true});*/

    },

    methods : {

        addKeyIndex(regenerate = false) {
            if (_.isArray(this.model.contents)) {
                this.model.contents.map((m, i) => {
                    m._upb_options['_keyIndex'] = `${i}`;

                    //this.addIndexAttribute(m, m.attributes, m.contents, regenerate);
                });
            }
        },

        addIndexAttribute(model, attrs, contents, regenerate = false) {
            if (_.isArray(contents)) {
                contents.map((m, i) => {
                    if (store.isElementRegistered(m.tag)) {
                        //m._upb_options['focus']     = false;

                        //if (regenerate) {
                        //    m._upb_options['_keyIndex'] = `${model._upb_options._keyIndex}/${i}`;
                        //}

                        //if (_.isUndefined(m._upb_options['_keyIndex'])) {
                        m._upb_options['_keyIndex'] = `${model._upb_options._keyIndex}/${i}`;
                        //}

                        this.addIndexAttribute(m, m.attributes, m.contents, regenerate);
                    }
                    else {
                        console.info(`%c Element "${m.tag}" is used but not registered. It's going to remove...`, 'color:red; font-size:18px');
                        this.model.contents.splice(i, 1);
                        store.stateChanged();
                        this.$toast.warning(sprintf(this.l10n.elementNotRegistered, m.tag));
                    }
                })
            }
        }
    }
}