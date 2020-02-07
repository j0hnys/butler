var state = {
    formValidate: {
        project_id: '',
        definition_id: '',
        entity_id: '',
        parent_id: '',
        name: '',
        type: '',
        functionality_data: '',
        request_data: '',
        response_data: '',
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
