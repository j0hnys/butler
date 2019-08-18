var state = {
    formValidate: {
        project_id: '',
        definition_id: '',
        name: '',
        functionality_data: '',
        request_data: '',
        response_data: '',
        db_table_name: '',
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
