var state = {
    formValidate: {
    },
    filters: {
        project_name: {
            selected: [],
            data: [],
        },
        entity_name: {
            selected: [],
            data: [],
        },
    }
};

export default {
    namespaced: true,
    state: state,
    mutations: {
        setFormValidate (state, data) 
        {
            state.formValidate = data;
        },
        setFilters (state, data) 
        {
            state.filters = data;
        },
    },
    getters: {
        formValidate (state) 
        {
            return state.formValidate;
        },
        filters (state) 
        {
            return state.filters;
        }
    }
};
