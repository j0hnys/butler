var state = {
    formValidate: {
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
