const main_menu = [
    {
        name: '1',
        icon_type: 'ios-navigate',
        text: 'Projects',
        redirect_url: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_list',
    },
    {
        name: '2',
        icon_type: 'ios-navigate',
        text: 'Definitions',
        redirect_url: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_list',
    },
    {
        name: '3',
        icon_type: 'ios-navigate',
        text: 'Entities',
        redirect_url: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/entity_list',
    },
    {
        name: '4',
        icon_type: 'ios-navigate',
        text: 'Views',
        redirect_url: process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/view_list',
    },
];
export default main_menu;