import MainMenu from '../../navigation/main_menu/main_menu.js';

var state = {
    breadcrumbs: [],
    navigation: {
        main_menu: MainMenu,
    }
};

export default {
    namespaced: true,
    state: state,
    mutations: {    //must be synchronous!! ta "actions" einai workflows praktika!!
        set_breadcrumbs (state, data) {
            state.breadcrumbs = data;
        },
    },
    getters: {
        breadcrumbs: (state) => {
            return state.breadcrumbs;
        },
        navigation: (state) => (data) => {
            return state.navigation;
        }
    },
};