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
    <div class="project_update">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>
                    test update
                </h1>


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
                    relative_schemas_folder: '',
                    db_connection_name: '',
                },
            };
            if (this.$store.state.pages.project_update) 
            {
                state = this.$store.state.pages.project_update;
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
                    db_connection_name: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The db_connection_name cannot be empty', 
                        }
                    ]

                },

            };
        },
        watch: {
            formValidate: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/project_update/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project/'+id ).then(({ data }) => {
                            self.formValidate = data;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    update(id,data) {

                        var form_data = new FormData();
                        form_data.append('_method', 'PATCH');
                        
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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project/'+id,  form_data ).then((response) => {
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

                        this.ajax().update(this.$route.params.id, formValidate);

                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            }
        },
        mounted() {
            // console.log('test form mounted');
            // console.log({
            //     // 'this.$store': this.$store,
            //     // 'this.$store.state': this.$store.state,
            //     // 'this.$store.state.Index': this.$store.state.Index,
            //     'this.$route': this.$route,
            // });

            this.ajax().get(this.$route.params.id);

        },
    }
</script>
