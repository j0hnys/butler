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
];
export default main_menu;