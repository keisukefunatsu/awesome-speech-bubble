import Vue from 'vue'
import App from './components/App.vue'
import VueResource from 'vue-resource'

window.onload = function () {
    Vue.use(VueResource)
    new Vue({
        el: '#app',
        render: h => h(App)
    });
}
