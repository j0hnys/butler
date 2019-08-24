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

                    <!-- <FormItem label="project_id" prop="project_id">
                        <InputNumber :disabled="true" v-model="formValidate.project_id" placeholder="Enter your project_id"></InputNumber>
                    </FormItem>
                    <FormItem label="definition_id" prop="definition_id">
                        <InputNumber :disabled="true" v-model="formValidate.definition_id" placeholder="Enter your definition_id"></InputNumber>
                    </FormItem> -->

                    <FormItem label="definition_id" prop="definition_id">
                        <Cascader :disabled="true" v-model="cascader_definition" :data="project_definitions" placeholder="---NOTHING SELECTED---"></Cascader>
                    </FormItem>

                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>

                    
                    <h1>Functionality</h1>
                    <Divider />
                    <FormItem label="db_table_name" prop="db_table_name">
                        <Select v-model="formValidate.db_table_name" style="width:200px" :loading="loading_models" loading-text="loading..." @on-open-change="onModelSelectClicked">
                            <Option v-for="item in database_tables" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                        <Button type="primary" @click="onGenerateDefaultValuesClicked">Generate Default Values</Button>
                    </FormItem>

                    
                    <FormItem></FormItem>

                    <h1>Request</h1>
                    <Divider />
                    <Table border :columns="request_table.columns" :data="request_table.data">
                        <template slot-scope="{ row, index }" slot="name">
                            <Input type="text" v-model="request_table.edit.name" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.name }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="type">
                            <Input type="text" v-model="request_table.edit.type" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.type }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="validation">
                            <Input type="text" v-model="request_table.edit.validation" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.validation }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="fillable">
                            <Input type="text" v-model="request_table.edit.fillable" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.fillable }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="action">
                            <div v-if="request_table.edit.index === index">
                                <Button type="success" size="small" @click="requestTableHandleSave(index)">Save</Button>
                                <Button type="warning" size="small" @click="request_table.edit.index = -1">Cancel</Button>
                            </div>
                            <div v-else>
                                <Button type="primary" size="small" @click="requestTableHandleEdit(row, index)">Edit</Button>
                                <Button type="error" size="small" @click="requestTableHandleDelete(index)">Delete</Button>
                            </div>
                        </template>
                    </Table>
                    <FormItem>
                        <Input hidden v-model="formValidate.request_data" placeholder=""></Input>
                    </FormItem>

                    <h1>Response</h1>
                    <Divider />
                    <Table border :columns="response_table.columns" :data="response_table.data">
                        <template slot-scope="{ row, index }" slot="name">
                            <Input type="text" v-model="response_table.edit.name" v-if="response_table.edit.index === index" />
                            <span v-else>{{ row.name }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="resource">
                            <Input type="text" v-model="response_table.edit.resource" v-if="response_table.edit.index === index" />
                            <span v-else>{{ row.resource }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="action">
                            <div v-if="response_table.edit.index === index">
                                <Button type="success" size="small" @click="responseTableHandleSave(index)">Save</Button>
                                <Button type="warning" size="small" @click="response_table.edit.index = -1">Cancel</Button>
                            </div>
                            <div v-else>
                                <Button type="primary" size="small" @click="responseTableHandleEdit(row, index)">Edit</Button>
                                <Button type="error" size="small" @click="responseTableHandleDelete(index)">Delete</Button>
                            </div>
                        </template>    
                    </Table>    
                    <FormItem>
                        <Input hidden v-model="formValidate.response_data" placeholder=""></Input>                
                    </FormItem>
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
                cascader_definition: [],
                project_definitions: [],
                loading_models: true,
                database_tables: [],
                request_table: {
                    edit: {
                        index: -1,
                        name: '',
                        type: '',
                        validation: '',
                        fillable: '',
                    },
                    columns: [
                        {
                            title: 'Name',
                            slot: 'name',
                            minWidth: 100,
                        },
                        {
                            title: 'Type',
                            slot: 'type',
                            minWidth: 100,
                        },
                        {
                            title: 'Validation',
                            slot: 'validation',
                            minWidth: 100,
                        },
                        {
                            title: 'Fillable',
                            slot: 'fillable',
                            minWidth: 100,
                        },
                        {
                            title: 'Action',
                            slot: 'action',
                            width: 150,
                            align: 'center',
                        }
                    ],
                    data: []
                },
                response_table: {
                    edit: {
                        index: -1,
                        name: '',
                        resource: '',
                    },
                    columns: [
                        {
                            title: 'Name',
                            slot: 'name',
                            minWidth: 100,
                        },
                        {
                            title: 'Resource',
                            slot: 'resource',
                            minWidth: 100,
                        },
                        {
                            title: 'Action',
                            slot: 'action',
                            width: 150,
                            align: 'center',
                        }
                    ],
                    data: []
                }
            };

            var state = {
                formValidate: {
                    project_id: '',
                    definition_id: '',
                    name: '',
                    functionality_data: '',
                    request_data: '',
                    response_data: '',
                    db_table_name: '',
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
                                                
                                                // let tmp_groups = [];

                                                // if (element_.groups.length > 0) {
                                                //     for (const k in element_.groups) {
                                                //         if (element_.groups.hasOwnProperty(k)) {
                                                //             const element__ = element_.groups[k];
                                                            
                                                //             tmp_groups.push({
                                                //                 value: element__.id,
                                                //                 label: element__.name,
                                                //                 data: element__
                                                //             });
                                                //         }
                                                //     }
                                                // }

                                                tmp_definitions.push({
                                                    value: element_.id,
                                                    label: element_.namespace,
                                                    data: element_,
                                                    // children: tmp_groups
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
                    get(id='') {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity/'+id ).then(({ data }) => {
                            self.formValidate = data;

                            self.database_tables = [
                                {
                                    label: data.db_table_name,
                                    value: data.db_table_name,
                                }
                            ];

                            self.cascader_definition = [
                                data.project_id,
                                data.definition_id
                            ]

                            self.request_table.data = JSON.parse(data.request_data);
                            self.response_table.data = JSON.parse(data.response_data);
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    getDefaultValues(definition_id, db_table_name) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_get/'+definition_id, {
                            params: {
                                db_table_name: db_table_name
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    getDatabaseTables(definition_id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_get_database_tables/'+definition_id ).catch(error => {
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

                        return window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity/'+id,  form_data ).then((response) => {
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
                        formValidate.request_data = JSON.stringify(this.request_table.data);
                        formValidate.response_data = JSON.stringify(this.response_table.data);

                        this.ajax().update(this.$route.params.id, formValidate);

                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            onGenerateDefaultValuesClicked() {
                this.ajax().getDefaultValues(
                    this.formValidate.definition_id,
                    this.formValidate.db_table_name
                ).then(({data}) => {
                    console.log(data);

                    this.request_table.data = data.request_table_data;
                    this.response_table.data = data.response_table_data;

                });
            },
            onModelSelectClicked() {
                this.loading_models = true;

                this.ajax().getDatabaseTables(
                    this.formValidate.definition_id,
                ).then(({data}) => {
                    this.database_tables = data.table_names;
                    this.loading_models = false;
                });
            },
            requestTableHandleEdit (row, index) {
                this.request_table.edit.name = row.name;
                this.request_table.edit.type = row.type;
                this.request_table.edit.validation = row.validation;
                this.request_table.edit.fillable = row.fillable;
                this.request_table.edit.index = index;
            },
            requestTableHandleSave (index) {
                this.request_table.data[index].name = this.request_table.edit.name;
                this.request_table.data[index].type = this.request_table.edit.type;
                this.request_table.data[index].validation = this.request_table.edit.validation;
                this.request_table.data[index].fillable = this.request_table.edit.fillable;
                this.request_table.edit.index = -1;
            },
            requestTableHandleDelete (index) {
                this.request_table.data.splice(index, 1);
            },
            responseTableHandleEdit (row, index) {
                this.response_table.edit.name = row.name;
                this.response_table.edit.resource = row.resource;
                this.response_table.edit.index = index;
            },
            responseTableHandleSave (index) {
                this.response_table.data[index].name = this.response_table.edit.name;
                this.response_table.data[index].resource = this.response_table.edit.resource;
                this.response_table.edit.index = -1;
            },
            responseTableHandleDelete (index) {
                this.response_table.data.splice(index, 1);
            }
        },
        mounted() {

            this.ajax().getProjectsWithDefinitions();
            this.ajax().get(this.$route.params.id);

        },
    }
</script>
