var state = {
    formValidate: {
        name: '',
        root_folder: '',
        relative_schemas_folder: '',
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
