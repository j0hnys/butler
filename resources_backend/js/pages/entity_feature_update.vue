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
    <div class="entity_feature_update">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>
                    test update
                </h1>


                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">

                    <FormItem label="project_id" prop="project_id">
                        <InputNumber v-model="formValidate.project_id" placeholder="Enter your project_id"></InputNumber>
                    </FormItem>
                    <FormItem label="definition_id" prop="definition_id">
                        <InputNumber v-model="formValidate.definition_id" placeholder="Enter your definition_id"></InputNumber>
                    </FormItem>
                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>
                    <FormItem label="functionality_data" prop="functionality_data">
                        <Input v-model="formValidate.functionality_data" placeholder="Enter your functionality_data"></Input>
                    </FormItem>
                    <FormItem label="request_data" prop="request_data">
                        <Input v-model="formValidate.request_data" placeholder="Enter your request_data"></Input>
                    </FormItem>
                    <FormItem label="response_data" prop="response_data">
                        <Input v-model="formValidate.response_data" placeholder="Enter your response_data"></Input>
                    </FormItem>
                    <FormItem label="db_table_name" prop="db_table_name">
                        <Input v-model="formValidate.db_table_name" placeholder="Enter your db_table_name"></Input>
                    </FormItem>
                    <FormItem label="type" prop="type">
                        <Input v-model="formValidate.type" placeholder="Enter your type"></Input>
                    </FormItem>
                    <FormItem label="parent_id" prop="parent_id">
                        <InputNumber v-model="formValidate.parent_id" placeholder="Enter your parent_id"></InputNumber>
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
                    project_id: '',
                    definition_id: '',
                    name: '',
                    functionality_data: '',
                    request_data: '',
                    response_data: '',
                    db_table_name: '',
                    type: '',
                    parent_id: '',
                },
            };
            if (this.$store.state.pages.entity_feature_update) 
            {
                state = this.$store.state.pages.entity_feature_update;
            }

            //
            //component state registration
            return {
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
                    definition_id: [
                        { 
                            required: true, 
                            type: 'number', 
                            trigger: 'blur',
                            message: 'The definition_id cannot be empty', 
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
                    functionality_data: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The functionality_data cannot be empty', 
                        }
                    ],
                    request_data: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The request_data cannot be empty', 
                        }
                    ],
                    response_data: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The response_data cannot be empty', 
                        }
                    ],
                    db_table_name: [
                        { 
                            required: true, 
                            type: 'string', 
                            trigger: 'blur',
                            message: 'The db_table_name cannot be empty', 
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
                    parent_id: [
                        { 
                            required: true, 
                            type: 'number', 
                            trigger: 'blur',
                            message: 'The parent_id cannot be empty', 
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
                    this.$store.commit('pages/entity_feature_update/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity/'+id ).then(({ data }) => {
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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity/'+id,  form_data ).then((response) => {
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
