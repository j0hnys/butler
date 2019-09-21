<style scoped>

</style>
<template>
    <div class="entity_create">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>Create</h1>

                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">
                    
                    <FormItem label="definition_id" prop="definition_id">
                        <Cascader v-model="formValidate.definition_id" :data="project_definitions" placeholder="---NOTHING SELECTED---"></Cascader>
                    </FormItem>

                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>
                                        
                    <FormItem>
                        <Button type="primary" @click="handleSubmit('formValidate')">Submit</Button>
                    </FormItem>
                </Form>

            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        data() {

            var local = {
                project_definitions: [],
            };

            var state = {
                formValidate: {
                    project_id: 0,
                    definition_id: [],
                    name: '',
                    functionality_data: '{}',
                    request_data: '[]',
                    response_data: '[]',
                    db_table_name: '{}',
                },
            };
            if (this.$store.state.pages.entity_create) 
            {
                // state = this.$store.state.pages.entity_create;
            }

            //
            //component state registration
            return {
                ...local,
                ...state,
                ruleValidate: {

                    project_id: [
                        { 
                            required: true, 
                            type: 'number', 
                            trigger: 'blur',
                            message: 'The project_id cannot be empty', 
                        }
                    ],
                    name: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The name cannot be empty', 
                        }
                    ],

                },

            };
        },
        watch: {
            formValidate: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/entity_create/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    getProjectsWithDefinitions() {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_get_with_definitions' ).then(({ data }) => {
                            let tmp_data = [];
                            for (const i in data) {
                                if (data.hasOwnProperty(i)) {
                                    const element = data[i];
                                    
                                    let tmp_definitions = [];

                                    if (element.definitions.length > 0) {
                                        for (const j in element.definitions) {
                                            if (element.definitions.hasOwnProperty(j)) {
                                                const element_ = element.definitions[j];

                                                tmp_definitions.push({
                                                    value: element_.id,
                                                    label: element_.namespace,
                                                    data: element_,
                                                });
                                            }
                                        }
                                    }

                                    tmp_data.push({
                                        value: element.id,
                                        label: element.name,
                                        data: element,
                                        children: tmp_definitions
                                    });

                                }
                            }
                    
                            self.project_definitions = tmp_data;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    create(data) {
                        let _data = JSON.parse(JSON.stringify(data));
                        _data.project_id = _data.definition_id[0];
                        _data.definition_id = _data.definition_id[1];

                        var form_data = new FormData();
                        
                        for (const key in _data) {
                            if (_data.hasOwnProperty(key)) {
                                const element = _data[key];
                                
                                if (key == 'file') {
                                    form_data.append(key, _data[key], _data[key].name);
                                } else {
                                    form_data.append(key, _data[key]);
                                }
                            }
                        }

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity',  form_data ).then((response) => {
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                }
            },
            handleUpload (file) {
                this.formValidate.file = file;
                return false;
            },
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        
                        var formValidate = this.formValidate;

                        this.ajax().create(formValidate);
                        
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
        },
        mounted() {
            
            this.ajax().getProjectsWithDefinitions();

        },
    }
</script>
