<style scoped>
    .index {
        width: 100%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        text-align: center;
    }
        .index h1 {
            height: 150px;
        }
            .index h1 img {
                height: 100%;
            }
        .index h2 {
            color: #666;
            margin-bottom: 200px;
        }
            .index h2 p {
                margin: 0 0 50px;
            }
    .ivu-row-flex {
        height: 100%;
    }
</style>
<template>
    <div class="view_create">
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
                    <FormItem label="type" prop="type">
                        <Input readonly v-model="formValidate.type" placeholder="Enter your type"></Input>
                    </FormItem>
                    <FormItem>
                        <Input hidden v-model="formValidate.presentation_data" placeholder=""></Input>
                    </FormItem>
                    <FormItem label="vista_resource_folder_name" prop="vista_resource_folder_name">
                        <Input readonly v-model="formValidate.vista_resource_folder_name" placeholder="Enter your vista_resource_folder_name"></Input>
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
                    project_id: '',
                    definition_id: '',
                    entity_id: '',
                    name: '',
                    type: 'form',
                    presentation_data: '{}',
                    vista_resource_folder_name: 'resources_backend',
                },
            };
            if (this.$store.state.pages.view_create) 
            {
                // state = this.$store.state.pages.view_create;
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
                    type: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The type cannot be empty', 
                        }
                    ],
                    presentation_data: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The presentation_data cannot be empty', 
                        }
                    ],
                    vista_resource_folder_name: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The vista_resource_folder_name cannot be empty', 
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
                    this.$store.commit('pages/view_create/setFormValidate', value);
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
                        data.entity_id = self.cascader_entity[2];

                        var form_data = new FormData();
                        
                        for (const key in data) {
                            if (data.hasOwnProperty(key)) {
                                const element = data[key];
                                
                                if (key == 'file') {
                                    form_data.append(key, data[key], data[key].name);
                                } else if (key == 'presentation_data') {
                                    form_data.append(key, '{}');
                                } else {
                                    form_data.append(key, data[key]);
                                }
                            }
                        }

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/view',  form_data ).then((response) => {
                            // Once AJAX resolves we can update the Crud with the new color
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
