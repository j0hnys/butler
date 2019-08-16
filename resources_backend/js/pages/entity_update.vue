<style scoped>
    .entity_update {
        height: 100vh;
    }
</style>
<template>
    <div class="entity_update">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>
                    test update
                </h1>

                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">

                    <FormItem label="project_id" prop="project_id">
                        <InputNumber :disabled="true" v-model="formValidate.project_id" placeholder="Enter your project_id"></InputNumber>
                    </FormItem>
                    <FormItem label="definition_id" prop="definition_id">
                        <InputNumber :disabled="true" v-model="formValidate.definition_id" placeholder="Enter your definition_id"></InputNumber>
                    </FormItem>
                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>

                    
                    <h1>Functionality</h1>
                    <Divider />
                    <FormItem label="model" prop="model">
                        <Select v-model="model" style="width:200px">
                            <Option v-for="item in database_tables" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                        <Button type="primary">Generate Default Values</Button>
                    </FormItem>

                    
                    <FormItem></FormItem>

                    <h1>Request</h1>
                    <Divider />
                    <Table border :columns="request_table.columns" :data="request_table.data"></Table>

                    <FormItem></FormItem>

                    <h1>Response</h1>
                    <Divider />
                    <Table border :columns="response_table.columns" :data="response_table.data"></Table>                    
                </Form>
            </Col>

        </Row>
        <Row type="flex" justify="end" align="middle" style="margin-top: 25px; margin-bottom: 15px;">
            <Col>
                <Button type="primary" @click="handleSubmit('formValidate')">Submit</Button>
            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        data() {

            var local = {
                model: '',
                database_tables: [
                    {
                        label: 'one',
                        value: 'one',
                    },
                    {
                        label: 'one1',
                        value: 'one1',
                    },
                    {
                        label: 'one2',
                        value: 'one2',
                    },
                ],
                request_table: {
                    columns: [
                        {
                            title: 'project_id',
                            key: 'project_id',
                            minWidth: 100,
                        },
                        {
                            title: 'definition_id',
                            key: 'definition_id',
                            minWidth: 100,
                        },
                        {
                            title: 'name',
                            key: 'name',
                            minWidth: 100,
                        },
                        {
                            title: 'Action',
                            key: 'action',
                            width: 150,
                            align: 'center',
                            render: (h, params) => {
                                var row = params.row;

                                return h('div', [
                                    h('Button', {
                                        props: {
                                            type: 'primary',
                                            size: 'small'
                                        },
                                        style: {
                                            marginRight: '5px'
                                        },
                                        on: {
                                            click: () => {
                                                this.$router.push({ name: 'entity_update', params: { id: row.id } });
                                            }
                                        }
                                    }, 'Edit'),
                                    h('Button', {
                                        props: {
                                            type: 'error',
                                            size: 'small'
                                        },
                                        on: {
                                            click: () => {
                                                this.ajax().delete(row.id);
                                            }
                                        }
                                    }, 'Delete')
                                ]);
                            }
                        }
                    ],
                    data: []
                },
                response_table: {
                    columns: [
                        {
                            title: 'project_id',
                            key: 'project_id',
                            minWidth: 100,
                        },
                        {
                            title: 'definition_id',
                            key: 'definition_id',
                            minWidth: 100,
                        },
                        {
                            title: 'name',
                            key: 'name',
                            minWidth: 100,
                        },
                        {
                            title: 'Action',
                            key: 'action',
                            width: 150,
                            align: 'center',
                            render: (h, params) => {
                                var row = params.row;

                                return h('div', [
                                    h('Button', {
                                        props: {
                                            type: 'primary',
                                            size: 'small'
                                        },
                                        style: {
                                            marginRight: '5px'
                                        },
                                        on: {
                                            click: () => {
                                                this.$router.push({ name: 'entity_update', params: { id: row.id } });
                                            }
                                        }
                                    }, 'Edit'),
                                    h('Button', {
                                        props: {
                                            type: 'error',
                                            size: 'small'
                                        },
                                        on: {
                                            click: () => {
                                                this.ajax().delete(row.id);
                                            }
                                        }
                                    }, 'Delete')
                                ]);
                            }
                        }
                    ],
                    data: []
                }
            };

            var state = {
                formValidate: {
                    project_id: '',
                    definition_id: '',
                    name: ''
                },
            };
            if (this.$store.state.pages.entity_update) 
            {
                state = this.$store.state.pages.entity_update;
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
                    this.$store.commit('pages/entity_update/setFormValidate', value);
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
