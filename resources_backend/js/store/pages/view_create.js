var state = {
    formValidate: {
        project_id: '',
        definition_id: '',
        entity_id: '',
        name: '',
        type: '',
        presentation_data: '',
        vista_resource_folder_name: '',
    },
};

export default {
    namespaced: true,
    state: state,
    mutations: {
        setFormValidate (state, data) 
        {
            state.formValidate = data;
        },
    },
    getters: {
        formValidate (state) 
        {
            return state.formValidate;
        }
    }
};
