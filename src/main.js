import Vue from 'vue'
import App from './App.vue'

( function ($, _, wp, api, data) {

    console.log(data);

    if (data) {
        new Vue({
            el     : '#app',
            data   : {
                id          : null,
                short_codes : [],
                drag_from   : {},
                drag_id     : null
            },
            render : h => h(App)
        })
    }

}(window.jQuery, window._, window.wp, window.wp.customize, window._UPB_Preview_Data || null) );

