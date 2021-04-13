import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)
import auth from './auth'
import error from './error';
import board from './board';


export default new Vuex.Store({
    strict: process.env.MIX_APP_ENV !== 'local',
    state:{
    },
    mutations:{
    },
    actions:{
    },
    getters:{
    },
    modules: {
        auth,
        board,
        error
    }
});
