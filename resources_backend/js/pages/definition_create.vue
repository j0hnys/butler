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
    <div class="definition_create">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>Create</h1>

                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">
                    
                    <FormItem label="project_id" prop="project_id">
                        <Select v-model="formValidate.project_id" style="width:200px" placeholder="-select project-">
                            <Option v-for="item in project_list" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="namespace" prop="namespace">
                        <Input readonly v-model="formValidate.namespace" placeholder="Enter your namespace"></Input>
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
                project_list: []
            };

            var state = {
                formValidate: {
                    project_id: '',
                    namespace: '\\App\\Trident\\Business\\Schemas\\Logic\\Definition\\Typed\\SchemaHierarchy',
                },
            };
            if (this.$store.state.pages.definition_create) 
            {
                // state = this.$store.state.pages.definition_create;
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
                    namespace: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The namespace cannot be empty', 
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
                    this.$store.commit('pages/definition_create/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    getProjects() {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project/' ).then(({ data }) => {
                            
                            let project_list = [];

                            for (const i in data) {
                                if (data.hasOwnProperty(i)) {
                                    const element = data[i];
                                    
                                    project_list.push({
                                        label: element.name,
                                        value: element.id
                                    });

                                }
                            }

                            self.project_list = project_list;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    create(data) {

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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/definition',  form_data ).then((response) => {
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

            this.ajax().getProjects();

        },
    }
</script>
