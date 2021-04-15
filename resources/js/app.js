import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import VueCookies from "vue-cookies";
Vue.use(VueCookies);

import App from './App.vue';
import router from './router';
import store from './store/index';

Vue.component('pagination', require('laravel-vue-pagination'));


import {
  ValidationObserver,
  ValidationProvider,
  extend,
  localize
} from "vee-validate";
import ko from "vee-validate/dist/locale/ko.json";
import * as rules from "vee-validate/dist/rules";

// Install VeeValidate rules and localization
Object.keys(rules).forEach(rule => {
  extend(rule, rules[rule]);
});

localize("ko", ko);

// Install VeeValidate components globally
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

Vue.config.productionTip = false;

const app = new Vue({
    router,
    store,
    beforeCreate() {
        this.$store.dispatch("auth/check");
    },
    render: h => h(App),
}).$mount('#app');
