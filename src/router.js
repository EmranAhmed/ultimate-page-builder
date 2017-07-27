import store from "./store";
import extend from "extend";
import VueRouter from "vue-router";
Vue.use(VueRouter);

let config = extend(true, {}, store.router_config);
let routes = [
    {
        path     : '',
        redirect : '/sections'
    },
    {
        name      : 'sections',
        path      : '/:tab(sections)',
        component : () => import(/* webpackChunkName: "SectionsPanel" */ './components/panels/SectionsPanel.vue'),
    },
    {
        name      : 'section-contents',
        path      : '/:tab(sections)/:sectionId(\\d+)/:type(contents)',
        component : () => import(/* webpackChunkName: "SectionContents" */ './components/section/SectionContents.vue'), // row list and column list
        meta      : {subPanel : true},
    },
    {
        name      : 'section-settings',
        path      : '/:tab(sections)/:sectionId(\\d+)/:type(settings)',
        component : () => import(/* webpackChunkName: "SectionSettings" */ './components/section/SectionSettings.vue'), // section setting
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
        component : () => import(/* webpackChunkName: "RowSettings" */ './components/row/RowSettings.vue'),
        meta      : {subPanel : true}
    },

    {
        name      : 'column-contents',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:type(contents)',
        component : () => import(/* webpackChunkName: "ColumnContents" */ './components/column/ColumnContents.vue'),
        meta      : {subPanel : true}
    },
    {
        name      : 'column-settings',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:type(settings)',
        component : () => import(/* webpackChunkName: "ColumnSettings" */ './components/column/ColumnSettings.vue'),
        meta      : {subPanel : true}
    },

    {
        name      : 'element-contents',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:elementId(\\d+)/:type(contents)',
        component : () => import(/* webpackChunkName: "ElementContents" */ './components/element/ElementContents.vue'),
        meta      : {subPanel : true}
    },
    {
        name      : 'element-settings',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:elementId(\\d+)/:type(settings)',
        component : () => import(/* webpackChunkName: "ElementSettings" */ './components/element/ElementSettings.vue'),
        meta      : {subPanel : true}
    },

    {
        name : 'element-item-contents',
        path : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:elementId(\\d+)/:elementItemId(\\d+)/:type(contents)',
        // component : ElementItemContents,
        meta : {subPanel : true}
    },
    {
        name      : 'element-item-settings',
        path      : '/:tab(sections)/:sectionId(\\d+)/:rowId(\\d+)/:columnId(\\d+)/:elementId(\\d+)/:elementItemId(\\d+)/:type(settings)',
        component : () => import(/* webpackChunkName: "ElementItemSettings" */ './components/element-item/ElementItemSettings.vue'),
        meta      : {subPanel : true}
    },
    {
        name      : 'elements',
        path      : '/:tab(elements)',
        component : () => import(/* webpackChunkName: "ElementsPanel" */ './components/panels/ElementsPanel.vue'),
    },
    {
        name      : 'settings',
        path      : '/:tab(settings)',
        component : () => import(/* webpackChunkName: "SettingsPanel" */ './components/panels/SettingsPanel.vue'),
    },
    {
        name      : 'layouts',
        path      : '/:tab(layouts)',
        component : () => import(/* webpackChunkName: "LayoutsPanel" */ './components/panels/LayoutsPanel.vue'),
    }
];

// New Routes from WP Hook
if (store.routes.length > 0) {
    store.routes.map((r) => {
        if (r['component']) {
            r.component = window[r.component];
            routes.push(r);
        }
    });
}

export default new VueRouter(Object.assign({}, config, {routes}));