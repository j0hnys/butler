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
    <div class="project_create">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>Create</h1>

                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">
                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>
                    <FormItem label="root_folder" prop="root_folder">
                        <Input v-model="formValidate.root_folder" placeholder="Enter your root_folder"></Input>
                    </FormItem>
                    <FormItem label="relative_schemas_folder" prop="relative_schemas_folder">
                        <Input v-model="formValidate.relative_schemas_folder" placeholder="Enter your relative_schemas_folder"></Input>
                    </FormItem>
                    <FormItem label="db_connection_name" prop="db_connection_name">
                        <Input v-model="formValidate.db_connection_name" placeholder="Enter your db_connection_name"></Input>
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
            var state = {
                formValidate: {
                    name: '',
                    root_folder: '',
                    relative_schemas_folder: 'app/Solution/Schemas',
                    db_connection_name: '',
                },
            };
            if (this.$store.state.pages.project_create) 
            {
                state = this.$store.state.pages.project_create;
            }

            //
            //component state registration
            return {
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
                    root_folder: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The root_folder cannot be empty', 
                        }
                    ],
                    relative_schemas_folder: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The relative_schemas_folder cannot be empty', 
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
                    this.$store.commit('pages/project_create/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project',  form_data ).then((response) => {
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
            //
        },
    }
</script>
