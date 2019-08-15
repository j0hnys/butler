//pages
var routes = require("./router.pages.js");

//sub menus
var sub_menus = require("./router.submenus.js");

const routers = [
    {
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/',
        title: 'otinanai',
        name: '/',
        component: routes.index,
        meta: {
            submenu: null,  //<--something like "demo_sub_menu" will go here
        }
    },
    { // add "import project_list_delete from './pages/project_list_delete.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_list',
        title: 'otinanai',
        name: 'project_list_delete',
        component: routes.project_list_delete,
        meta: {
            submenu: null,
        }
    },
    { // add "import project_create from './pages/project_create.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_create',
        title: 'otinanai',
        name: 'project_create',
        component: routes.project_create,
        meta: {
            submenu: null,
        }
    },
    { // add "import project_update from './pages/project_update.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_update/:id',
        title: 'otinanai',
        name: 'project_update',
        component: routes.project_update,
        meta: {
            submenu: null,
        }
    },
];
export default routers;