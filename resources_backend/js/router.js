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
    { // add "import definition_list_delete from './pages/definition_list_delete.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_list',
        title: 'otinanai',
        name: 'definition_list_delete',
        component: routes.definition_list_delete,
        meta: {
            submenu: null,
        }
    },
    { // add "import definition_create from './pages/definition_create.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_create',
        title: 'otinanai',
        name: 'definition_create',
        component: routes.definition_create,
        meta: {
            submenu: null,
        }
    },
    { // add "import definition_update from './pages/definition_update.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_update/:id',
        title: 'otinanai',
        name: 'definition_update',
        component: routes.definition_update,
        meta: {
            submenu: null,
        }
    },
    { // add "import entity_list_delete from './pages/entity_list_delete.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/entity_list',
        title: 'otinanai',
        name: 'entity_list_delete',
        component: routes.entity_list_delete,
        meta: {
            submenu: null,
        }
    },
    { // add "import entity_create from './pages/entity_create.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/entity_create',
        title: 'otinanai',
        name: 'entity_create',
        component: routes.entity_create,
        meta: {
            submenu: null,
        }
    },
    { // add "import entity_update from './pages/entity_update.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/entity_update/:id',
        title: 'otinanai',
        name: 'entity_update',
        component: routes.entity_update,
        meta: {
            submenu: null,
        }
    },
    { // add "import view_list_delete from './pages/view_list_delete.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/view_list',
        title: 'otinanai',
        name: 'view_list_delete',
        component: routes.view_list_delete,
        meta: {
            submenu: null,
        }
    },
    { // add "import view_create from './pages/view_create.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/view_create',
        title: 'otinanai',
        name: 'view_create',
        component: routes.view_create,
        meta: {
            submenu: null,
        }
    },
    { // add "import view_update from './pages/view_update.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/view_update/:id',
        title: 'otinanai',
        name: 'view_update',
        component: routes.view_update,
        meta: {
            submenu: null,
        }
    },
    { // add "import test_list_delete from './pages/test_list_delete.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/test_list',
        title: 'otinanai',
        name: 'test_list_delete',
        component: routes.test_list_delete,
        meta: {
            submenu: null,
        }
    },
    { // add "import test_create from './pages/test_create.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/test_create',
        title: 'otinanai',
        name: 'test_create',
        component: routes.test_create,
        meta: {
            submenu: null,
        }
    },
    { // add "import test_update from './pages/test_update.vue';" at the top
        path: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/test_update/:id',
        title: 'otinanai',
        name: 'test_update',
        component: routes.test_update,
        meta: {
            submenu: null,
        }
    },
];
export default routers;