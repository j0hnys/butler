<style scoped>
    .test_feature_update {
        height: 100vh;
    }
</style>
<template>
    <div class="test_feature_update">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>Update</h1>


                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="150">

                    <FormItem label="test_id" prop="test_id">
                        <Cascader :disabled="true" v-model="cascader_test" :data="project_definitions_entities_tests" placeholder="---NOTHING SELECTED---"></Cascader>
                    </FormItem>

                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>
                    <FormItem label="type" prop="type">
                        <Input readonly v-model="formValidate.type" placeholder="Enter your type"></Input>
                    </FormItem>

                    <FormItem>
                        <Button type="primary" @click="onGenerateDefaultValuesClicked">Generate Default Values</Button>
                    </FormItem>

                    <FormItem></FormItem>

                    <h1>
                        Request
                        <Tooltip content="" max-width="600">
                            <Icon type="ios-information-circle" style="font-size:0.7em;" />
                            <div slot="content">
                                <strong>Property Type</strong>
                                <p><i>values: `default`, `auto_id` </i></p>
                                <br>
                                <strong>Value</strong>
                                <p><i>string or integer</i></p>
                            </div>
                        </Tooltip>
                        <Button type="primary" ghost @click="onAddPropertyButtonClicked('request_table')">Add property</Button>
                    </h1>
                    <Divider />
                    <Table border :columns="request_table.columns" :data="request_table.data" no-data-text="-no data-">
                        <template slot-scope="{ row, index }" slot="name">
                            <Input type="text" v-model="request_table.edit.name" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.name }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="property_type">
                            <Input type="text" v-model="request_table.edit.property_type" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.property_type }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="value">
                            <Input type="text" v-model="request_table.edit.value" v-if="request_table.edit.index === index" />
                            <span v-else>{{ row.value }}</span>
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

                    <h1>
                        Response
                        <Tooltip content="" max-width="600">
                            <Icon type="ios-information-circle" style="font-size:0.7em;" />
                            <div slot="content">
                                <strong>Property Type</strong>
                                <p><i>values: `default`, `auto_id` </i></p>
                                <br>
                                <strong>Value</strong>
                                <p><i>string or integer</i></p>
                            </div>
                        </Tooltip>
                        <Button type="primary" ghost @click="onAddPropertyButtonClicked('response_table')">Add property</Button>
                    </h1>
                    <Divider />
                    <Table border :columns="response_table.columns" :data="response_table.data" no-data-text="-no data-">
                        <template slot-scope="{ row, index }" slot="name">
                            <Input type="text" v-model="response_table.edit.name" v-if="response_table.edit.index === index" />
                            <span v-else>{{ row.name }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="property_type">
                            <Input type="text" v-model="response_table.edit.property_type" v-if="response_table.edit.index === index" />
                            <span v-else>{{ row.property_type }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="value">
                            <Input type="text" v-model="response_table.edit.value" v-if="response_table.edit.index === index" />
                            <span v-else>{{ row.value }}</span>
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
        props: {
            parent_id: {
                type: Number,
                default: 0,
            }
        },
        data() {
            var local = {
                cascader_test: [],
                project_definitions_entities_tests: [],
                loading_models: true,
                request_table: {
                    edit: {
                        index: -1,
                        name: '',
                        property_type: '',
                        value: '',
                    },
                    columns: [
                        {
                            title: 'Name',
                            slot: 'name',
                            minWidth: 100,
                        },
                        {
                            title: 'Property Type',
                            slot: 'property_type',
                            minWidth: 100,
                        },
                        {
                            title: 'Value',
                            slot: 'value',
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
                        property_type: '',
                        value: '',
                    },
                    columns: [
                        {
                            title: 'Name',
                            slot: 'name',
                            minWidth: 100,
                        },
                        {
                            title: 'property_type',
                            slot: 'property_type',
                            minWidth: 100,
                        },
                        {
                            title: 'Value',
                            slot: 'value',
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
            }

            var state = {
                formValidate: {
                    project_id: '',
                    definition_id: '',
                    entity_id: '',
                    test_id: '',
                    name: '',
                    type: '',
                    functionality_data: '',
                    request_data: '',
                    response_data: '',
                    parent_id: 0,
                },
            };
            if (this.$store.state.pages.test_update) 
            {
                // state = this.$store.state.pages.test_update;
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
                },

            };
        },
        watch: {
            formValidate: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/test_feature_update/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    getProjectsWithDefinitionsEntitiesTests() {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_get_with_definitions_entities_tests' ).then(({ data }) => {
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

                                                            let tmp_tests = [];

                                                            if (element__.tests.length > 0) {
                                                                for (const l in element__.tests) {
                                                                    if (element__.tests.hasOwnProperty(l)) {
                                                                        const element___ = element__.tests[l];
                                                                        
                                                                        tmp_tests.push({
                                                                            value: element___.id,
                                                                            label: element___.name,
                                                                            data: element___,
                                                                        });

                                                                    }
                                                                }
                                                            }
                                                            
                                                            tmp_entities.push({
                                                                value: element__.id,
                                                                label: element__.name,
                                                                data: element__,
                                                                children: tmp_tests
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
                    
                            self.project_definitions_entities_tests = tmp_data;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    get(id='') {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/test/'+id ).then(({ data }) => {
                            self.formValidate = data;

                            self.cascader_test = [
                                data.project_id,
                                data.definition_id,
                                data.entity_id,
                                data.id
                            ];

                            console.log({
                                'self.cascader_test': self.cascader_test,
                            });

                            self.request_table.data = JSON.parse(data.request_data);
                            self.response_table.data = JSON.parse(data.response_data);
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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/test/'+id,  form_data ).then((response) => {
                            // Once AJAX resolves we can update the Crud with the new color
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    getDefaultValues(definition_id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/definition_get_by_entity_id/'+definition_id, {
                            params: {
                                entity_id: self.formValidate.entity_id
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                }
            },
            onAddPropertyButtonClicked(table_name) {
                let new_line = JSON.parse(JSON.stringify(this[table_name].data[ this[table_name].data.length-1 ]));
                for (const key in new_line) {
                    if (new_line.hasOwnProperty(key)) {
                        const element = new_line[key];
                        
                        new_line[key] = '---';
                    }
                }
                this[table_name].data.push(new_line);
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
                    this.formValidate.definition_id
                ).then(({data}) => {
                    this.request_table.data = data.tests_request_table_data;
                    this.response_table.data = data.tests_response_table_data;
                });
            },
            requestTableHandleEdit (row, index) {
                this.request_table.edit.name = row.name;
                this.request_table.edit.property_type = row.property_type;
                this.request_table.edit.value = row.value;
                this.request_table.edit.index = index;
            },
            requestTableHandleSave (index) {
                this.request_table.data[index].name = this.request_table.edit.name;
                this.request_table.data[index].property_type = this.request_table.edit.property_type;
                this.request_table.data[index].value = this.request_table.edit.value;
                this.request_table.edit.index = -1;
            },
            requestTableHandleDelete (index) {
                this.request_table.data.splice(index, 1);
            },
            responseTableHandleEdit (row, index) {
                this.response_table.edit.name = row.name;
                this.response_table.edit.property_type = row.property_type;
                this.response_table.edit.value = row.value;
                this.response_table.edit.index = index;
            },
            responseTableHandleSave (index) {
                this.response_table.data[index].name = this.response_table.edit.name;
                this.response_table.data[index].property_type = this.response_table.edit.property_type;
                this.response_table.data[index].value = this.response_table.edit.value;
                this.response_table.edit.index = -1;
            },
            responseTableHandleDelete (index) {
                this.response_table.data.splice(index, 1);
            }
        },
        mounted() {
            
            this.ajax().getProjectsWithDefinitionsEntitiesTests().then(() => {
                return this.ajax().get(this.$route.params.id);
            });

        },
    }
</script>
