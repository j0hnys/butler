<style scoped>
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
    .table-filters {
        margin-bottom: 20px;
    }
</style>
<template>
    <div class="entity_list_delete">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">

                <Row type="flex" justify="end" style="margin-bottom: 20px;">
                    <Col>
                        <Button type="primary" @click="onCreateButtonClicked">Create</Button>
                    </Col>
                </Row>

                <Row>
                    <Col>
                        <Table :loading="table.loading.state" border :columns="columns" :data="data" no-data-text="-no data-">
                            <template slot="loading">
                                <Icon type="ios-loading" size=18 class="demo-spin-icon-load"></Icon>
                                {{table.loading.text}}
                            </template>
                        </Table>
                     </Col>
                </Row>

            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        data() {
            var local = {
                table: {
                    loading: {
                        state: true,
                        text: 'loading',
                    },
                }
            };

            var state = {
                formValidate: {
                },
                filters: {
                    project_name: {
                        selected: [],
                        data: [],
                    },
                }
            };
            if (this.$store.state.pages.entity_list_delete) 
            {
                state = this.$store.state.pages.entity_list_delete;
            }


            //
            //component state registration
            return {
                ...local,
                ...state,
                columns: [
                    {
                        title: 'project_name',
                        key: 'project_name',
                        minWidth: 100,
                    },
                    {
                        title: 'definition_namespace',
                        key: 'definition_namespace',
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
                        maxWidth: 270,
                        minWidth: 270,
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
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.$Modal.confirm({
                                                title: 'Attention',
                                                content: 'Are you sure you want to delete?',
                                                okText: 'Delete',
                                                cancelText: 'Cancel',
                                                onOk: () => {
                                                    this.ajax().delete(row.id);
                                                }
                                            });
                                        }
                                    }
                                }, 'Delete'),
                                h('Button', {
                                    props: {
                                        type: 'success',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.table.loading.state = true;
                                            this.table.loading.text = 'generating...';
                                            this.ajax().generate(row.id).then(() => {
                                                this.table.loading.state = false;
                                            });
                                        }
                                    }
                                }, 'Generate'),
                                h('Button', {
                                    props: {
                                        type: 'warning',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () => {
                                            this.table.loading.state = true;
                                            this.table.loading.text = 'updating...';
                                            this.ajax().updateResource(row.id).then(() => {
                                                this.table.loading.state = false;
                                            });
                                        }
                                    }
                                }, 'Update')
                            ]);
                        }
                    }
                ],
                server_data: [],
                data: []


            };
        },
        watch: {
            formValidate: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/entity_list_delete/setFormValidate', value);
                }
            },
            filters: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/entity_list_delete/setFilters', value);
                }
            },
            data: {
                deep: true,
                handler: function(value) {
                    let tmp_table = [];
                    for (const i in value) {
                        if (value.hasOwnProperty(i)) {
                            const element = value[i];
                            tmp_table.push({
                                'label': element.project_name,
                                'value': element.project_name,
                            });
                        }
                    }

                    this.filters.project_name.data = tmp_table;
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity'+id ).then(({ data }) => {
                            self.server_data = data;
                            self.data = data;
                            self.table.loading.state = false;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/entity/'+id ).then(({ data }) => {
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    generate(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/entity_generate/'+id ).then(({ data }) => {
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                            self.$Message.error('could not generate, see network');
                        });
                    },
                    updateResource(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/entity_update_schemas/'+id ).then(({ data }) => {
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                            self.$Message.error('could not update, see network');
                        });
                    }
                }
            },
            onCreateButtonClicked() {
                this.$router.push({ name: 'entity_create' });
            },
            onClearAllButtonClicked() {
                let filters = this.filters;

                for (const key in filters) {
                    if (filters.hasOwnProperty(key)) {
                        const element = filters[key];
                        
                        filters[key].selected = [];
                    }
                }

                this.filters = filters;
            },
        },
        mounted() {

            this.ajax().get();

        },
    }
</script>
