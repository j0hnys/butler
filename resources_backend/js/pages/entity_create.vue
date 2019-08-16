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
    <div class="entity_create">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>
                    test
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
                },
            };
            if (this.$store.state.pages.entity_create) 
            {
                state = this.$store.state.pages.entity_create;
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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity',  form_data ).then((response) => {
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
            // console.log('test form mounted');
            // console.log({
            //     // 'this.$store': this.$store,
            //     // 'this.$store.state': this.$store.state,
            //     // 'this.$store.state.Index': this.$store.state.Index,
            //     'this.$route': this.$route,
            // });
        },
    }
</script>
