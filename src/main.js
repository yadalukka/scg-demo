// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import '../public/css/sb-admin-2.css'
import '../public/css/style.css'
import '../public/js/sb-admin-2.js'
import '@fortawesome/fontawesome-free/css/all.css';

Vue.config.productionTip = false

import Sidebar from './components/Sidebar.vue'
import Body from './components/Body.vue';
import Restaurants from './components/Restaurants.vue';

Vue.component('sidebar-component', Sidebar);
Vue.component('body-component', Body);
Vue.component('restaurants-component', Restaurants);

const app = new Vue({
    el: '#wrapper'
});
