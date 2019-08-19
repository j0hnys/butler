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
    <div class="view_update">
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
                    <FormItem label="entity_id" prop="entity_id">
                        <InputNumber :disabled="true" v-model="formValidate.entity_id" placeholder="Enter your entity_id"></InputNumber>
                    </FormItem>
                    <FormItem label="name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter your name"></Input>
                    </FormItem>
                    <FormItem label="type" prop="type">
                        <Input v-model="formValidate.type" placeholder="Enter your type"></Input>
                    </FormItem>

                    <FormItem></FormItem>

                    <h1>Presentation</h1>
                    <Divider />
                    <Table border :columns="presentation_table.columns" :data="presentation_table.data">
                        <template slot-scope="{ row, index }" slot="column_name">
                            <Input type="text" v-model="presentation_table.edit.column_name" v-if="presentation_table.edit.index === index" />
                            <span v-else>{{ row.column_name }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="column_type">
                            <Input type="text" v-model="presentation_table.edit.column_type" v-if="presentation_table.edit.index === index" />
                            <span v-else>{{ row.column_type }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="type">
                            <Input type="text" v-model="presentation_table.edit.type" v-if="presentation_table.edit.index === index" />
                            <span v-else>{{ row.type }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="validation_rules">
                            <Input type="text" v-model="presentation_table.edit.validation_rules" v-if="presentation_table.edit.index === index" />
                            <span v-else>{{ row.validation_rules }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="attributes">
                            <Input type="text" v-model="presentation_table.edit.attributes" v-if="presentation_table.edit.index === index" />
                            <span v-else>{{ row.attributes }}</span>
                        </template>

                        <template slot-scope="{ row, index }" slot="action">
                            <div v-if="presentation_table.edit.index === index">
                                <Button type="success" size="small" @click="presentationTableHandleSave(index)">Save</Button>
                                <Button type="warning" size="small" @click="presentation_table.edit.index = -1">Cancel</Button>
                            </div>
                            <div v-else>
                                <Button type="primary" size="small" @click="presentationTableHandleEdit(row, index)">Edit</Button>
                                <Button type="error" size="small" @click="presentationTableHandleDelete(index)">Delete</Button>
                            </div>
                        </template>
                    </Table>
                    <FormItem>
                        <Input hidden v-model="formValidate.presentation_data" placeholder=""></Input>
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

                presentation_table: {
                    edit: {
                        index: -1,
                        column_name: '',
                        column_type: '',
                        type: '',
                        validation_rules: '',
                        attributes: '',
                    },
                    columns: [
                        {
                            title: 'column_name',
                            slot: 'column_name',
                            minWidth: 100,
                        },
                        {
                            title: 'column_type',
                            slot: 'column_type',
                            minWidth: 100,
                        },
                        {
                            title: 'type',
                            slot: 'type',
                            minWidth: 100,
                        },
                        {
                            title: 'validation_rules',
                            slot: 'validation_rules',
                            minWidth: 100,
                        },
                        {
                            title: 'attributes',
                            slot: 'attributes',
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
                
            }

            var state = {
                formValidate: {
                    project_id: '',
                    definition_id: '',
                    entity_id: '',
                    name: '',
                    type: '',
                    presentation_data: '',
                },
            };
            if (this.$store.state.pages.view_update) 
            {
                state = this.$store.state.pages.view_update;
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
                    entity_id: [
                        { 
                            required: true, 
                            type: 'number', 
                            trigger: 'blur',
                            message: 'The entity_id cannot be empty', 
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

                },

            };
        },
        watch: {
            formValidate: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/view_update/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/view/'+id ).then(({ data }) => {
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

                        window.axios.post( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/view/'+id,  form_data ).then((response) => {
                            // Once AJAX resolves we can update the Crud with the new color
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    getDefaultValues(entity_id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/view_definition_get/'+entity_id, {
                            params: {
                                entity_id: entity_id
                            }
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
                        formValidate.presentation_data = JSON.stringify(this.presentation_table.data);

                        this.ajax().update(this.$route.params.id, formValidate);

                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            onGenerateDefaultValuesClicked() {
                this.ajax().getDefaultValues(
                    this.formValidate.entity_id
                ).then(({data}) => {
                    console.log(data);

                    this.presentation_table.data = data.presentation_table_data;

                });
            },
            presentationTableHandleEdit (row, index) {
                this.presentation_table.edit.column_name = row.column_name;
                this.presentation_table.edit.column_type = row.column_type;
                this.presentation_table.edit.type = row.type;
                this.presentation_table.edit.validation_rules = row.validation_rules;
                this.presentation_table.edit.attributes = row.attributes;
                this.presentation_table.edit.index = index;
            },
            presentationTableHandleSave (index) {
                this.presentation_table.data[index].column_name = this.presentation_table.edit.column_name;
                this.presentation_table.data[index].column_type = this.presentation_table.edit.column_type;
                this.presentation_table.data[index].type = this.presentation_table.edit.type;
                this.presentation_table.data[index].validation_rules = this.presentation_table.edit.validation_rules;
                this.presentation_table.data[index].attributes = this.presentation_table.edit.attributes;
                this.presentation_table.edit.index = -1;
            },
            presentationTableHandleDelete (index) {
                this.presentation_table.data.splice(index, 1);
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

            this.ajax().get(this.$route.params.id);

        },
    }
</script>
