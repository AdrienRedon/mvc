import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

new Vue({
    el: "#app",
    render: h => h(require('./components/App'))
});