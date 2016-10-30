import Vue from 'vue'
import App from './App.vue'

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



