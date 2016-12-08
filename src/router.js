import store from './store'
import extend from 'extend'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

import SectionsPanel from './components/panels/SectionsPanel.vue'
import SettingsPanel from './components/panels/SettingsPanel.vue'
import ElementsPanel from './components/panels/ElementsPanel.vue'

// RowsPanel
import SectionContents from './components/section/SectionContents.vue'
import SectionSettings from './components/section/SectionSettings.vue'

// RowsPanel
import RowSettings from './components/row/RowSettings.vue'

// ColumnPanel
import ColumnContents from './components/column/ColumnContents.vue'
//import ColumnSettings from './components/column/ColumnSettings.vue'

//import Attributes from './components/tabs/Attributes.vue'
//import List from './components/tabs/ListView.vue'

let config = extend(true, {}, store.router_config);
let routes = [
    {
        path     : '',
        redirect : '/sections'
    },
    {
        name      : 'sections',
        path      : '/:tab(sections)',
        component : SectionsPanel,
    },

    {
        name      : 'section-contents',
        path      : '/:tab(sections)/:sectionId(\\d+)/:type(contents)',
        component : SectionContents, // row list and column list
        meta      : {subPanel : true},
    },
    {
        name      : 'section-settings',
        path      : '/:tab(sections)/:sectionId(\\d+)/:type(settings)',
        component : SectionSettings, // section setting
        meta      : {subPanel : true}
    },

    {
        name      : 'row-contents',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:type(contents)',
        component : {
            template : '<span></span>',
            created(){
                this.$router.replace(`/sections/${this.$route.params.sectionId}/${this.$route.params.type}`);
            }
        },
        meta      : {subPanel : true},
    },
    {
        name      : 'row-settings',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:type(settings)',
        component : RowSettings,
        meta      : {subPanel : true}
    },

    {
        name      : 'column-contents',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:type(contents)',
        component : ColumnContents,
        meta      : {subPanel : true}
    },
    {
        name : 'column-settings',
        path : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:type(settings)',
        //component : Attributes,
        meta : {subPanel : true}
    },

    // element
    // element-item
    // element-item-contents

    {
        name      : 'elements',
        path      : '/:tab(elements)',
        component : ElementsPanel
    },

    {
        name      : 'settings',
        path      : '/:tab(settings)',
        component : SettingsPanel
    }
];

// New Routes from Hook
if (store.routes.length > 0) {
    store.routes.map((r)=> {
        if (r['component']) {
            r.component = window[r.component];
            routes.push(r);
        }
    });
}

export default new VueRouter(Object.assign({}, config, {routes}));

/*
 export default new VueRouter(extend(true, store.router_config, {
 routes : [
 {
 name      : 'sections',
 path      : '/:tab(sections)',
 component : PanelView,
 },

 {
 name      : 'section-contents',
 path      : '/:tab(sections)/(\\d+)/:type(contents)',
 component : List, // row list
 meta      : {sub : true}
 },
 {
 name      : 'section-settings',
 path      : '/:tab(sections)/(\\d+)/:type(settings)',
 component : Attributes, // section setting
 meta      : {sub : true}
 },

 {
 name      : 'row-contents',
 path      : '/:tab(sections)/(\\d+)/(\\d+)/:type(contents)',
 component : List, // column list
 meta      : {sub : true}
 },
 {
 name      : 'row-settings',
 path      : '/:tab(sections)/(\\d+)/(\\d+)/:type(settings)',
 component : Attributes,
 meta      : {sub : true}
 },

 {
 name      : 'column-contents',
 path      : '/:tab(sections)/(\\d+)/(\\d+)/(\\d+)/:type(contents)',
 component : List,
 meta      : {sub : true}
 },
 {
 name      : 'column-settings',
 path      : '/:tab(sections)/(\\d+)/(\\d+)/(\\d+)/:type(settings)',
 component : Attributes,
 meta      : {sub : true}
 },

 {
 name      : 'settings',
 path      : '/:tab(settings)',
 component : PanelView
 },
 {
 path     : '',
 redirect : '/sections'
 }
 ]
 }));
 */

