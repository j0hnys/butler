<style scoped>

</style>
<template>
    <div class="entity_feature_create">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>Create</h1>

                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">
                    
                    <FormItem label="entity_id" prop="entity_id">
                        <Cascader v-model="cascader_entity" :data="project_definitions_entities" placeholder="---NOTHING SELECTED---"></Cascader>
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
                cascader_entity: [],
                project_definitions_entities: [],
            };

            var state = {
                formValidate: {
                    project_id: 0,
                    definition_id: [],
                    name: '',
                    functionality_data: '{"model":{"db_name":""},"endpoint":{"uri":"/","group":"","type":"read"}}',
                    request_data: '[]',
                    response_data: '[]',
                    db_table_name: '{}',
                    type: 'feature',
                    parent_id: 0,
                },
            };
            if (this.$store.state.pages.entity_feature_create) 
            {
                // state = this.$store.state.pages.entity_create;
            }

            //
            //component state registration
            return {
                ...local,
                ...state,
                ruleValidate: {
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
                    this.$store.commit('pages/entity_feature_create/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    getProjectsWithDefinitionsEntities() {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_get_with_definitions_entities' ).then(({ data }) => {
                            let tmp_data = [];
                            for (const i in data) {
                                if (data.hasOwnProperty(i)) {
                                    const element = data[i];
                                    
                                    let tmp_definitions = [];

                                    if (element.definitions.length > 0) {
                                        for (const j in element.definitions) {
                                            if (element.definitions.hasOwnProperty(j)) {
                                                const element_ = element.definitions[j];
                                                
                                                let tmp_entities = [];

                                                if (element_.entities.length > 0) {
                                                    for (const k in element_.entities) {
                                                        if (element_.entities.hasOwnProperty(k)) {
                                                            const element__ = element_.entities[k];
                                                            
                                                            tmp_entities.push({
                                                                value: element__.id,
                                                                label: element__.name,
                                                                data: element__
                                                            });
                                                        }
                                                    }
                                                }

                                                tmp_definitions.push({
                                                    value: element_.id,
                                                    label: element_.namespace,
                                                    data: element_,
                                                    children: tmp_entities
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
                    
                            self.project_definitions_entities = tmp_data;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    create(data) {
                        data.project_id = self.cascader_entity[0];
                        data.definition_id = self.cascader_entity[1];
                        data.parent_id = self.cascader_entity[2];

                        var form_data = new FormData();
                        
                        for (const key in data) {
                            if (data.hasOwnProperty(key)) {
                                const element = data[key];
                                
                                if (key == 'file') {
                                    form_data.append(key, data[key], data[key].name);
                                } else {
                                    form_data.append(key, data[key]);
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
            
            this.ajax().getProjectsWithDefinitionsEntities();

        },
    }
</script>
