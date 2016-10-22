import Vue from 'vue'
import App from './App.vue'

(function (api, wp, $) {

    alert('I AM HERE');

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

})(wp.customize, wp, jQuery);