import store from './store'
import extend from 'extend'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

import Sections from './components/tabs/Sections.vue'
import Settings from './components/tabs/Settings.vue'

import List from './components/tabs/ListView.vue'
import Attributes from './components/tabs/Attributes.vue'

export default new VueRouter(extend(true, store.router_config, {
    routes : [
        {
            name      : 'sections',
            path      : '/sections',
            component : Sections,
            children  : [
                {
                    name      : 'section-contents',
                    path      : '(\\d+)/:type(contents)',
                    component : List,
                    meta      : {sub : true}
                },
                {
                    name      : 'section-settings',
                    path      : '(\\d+)/:type(settings)',
                    component : Attributes,
                    meta      : {sub : true}
                },

                {
                    name      : 'row-contents',
                    path      : '(\\d+)/(\\d+)/:type(contents)',
                    component : List,
                    meta      : {sub : true}
                },
                {
                    name      : 'row-settings',
                    path      : '(\\d+)/(\\d+)/:type(settings)',
                    component : Attributes,
                    meta      : {sub : true}
                },

                {
                    name      : 'column-contents',
                    path      : '(\\d+)/(\\d+)/(\\d+)/:type(contents)',
                    component : List,
                    meta      : {sub : true}
                },
                {
                    name      : 'column-settings',
                    path      : '(\\d+)/(\\d+)/(\\d+)/:type(settings)',
                    component : Attributes,
                    meta      : {sub : true}
                }

            ]
        },
        {
            name      : 'settings',
            path      : '/settings',
            component : Settings
        },
        {
            path     : '',
            redirect : '/sections'
        }
    ]
}));

