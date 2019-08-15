import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import Index from './store/pages/Index.js';
import BasicLayout from './store/components/BasicLayout.js';
var stores = require("./store.pages.js");

Vue.use(Vuex);

window.Vuex = require('vuex');

const store = new Vuex.Store({
    plugins: [createPersistedState()],
    state: {
        base_url: process.env.MIX_BASE_URL+'/',
        base_relative_url: process.env.MIX_BASE_RELATIVE_URL+'/',
        storage_url: process.env.MIX_STORAGE_URL+'/',
    },
    modules: {
        components: {
            namespaced: true,
            modules: {
                BasicLayout: BasicLayout,
            }
        },
        pages: {
            namespaced: true,
            modules: {
                Index: stores.index,
                project_list_delete: stores.project_list_delete,
                project_create: stores.project_create,
                project_update: stores.project_update,
            }
        },
    },
});

export default store;
