<style scoped>
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
</style>
<template>
    <div class="test_feature_list_delete">
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
        props: {
            parent_id: {
                type: Number,
                default: 0,
            }
        },
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
            };
            if (this.$store.state.pages.test_list_delete) 
            {
                state = this.$store.state.pages.test_list_delete;
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
                        minWidth: 150,
                        maxWidth: 150,
                    },
                    {
                        title: 'definition_namespace',
                        key: 'definition_namespace',
                        minWidth: 190,
                        maxWidth: 190,
                    },
                    {
                        title: 'entity_name',
                        key: 'entity_name',
                        minWidth: 120,
                        maxWidth: 120,
                    },
                    {
                        title: 'name',
                        key: 'name',
                        minWidth: 100,
                        maxWidth: 100,
                    },
                    {
                        title: 'Action',
                        key: 'action',
                        minwidth: 250,
                        maxwidth: 250,
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
                                            this.$router.push({ name: 'test_feature_update', params: { id: row.id } });
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
                                            this.ajax().updateFeature(row.id).then(() => {
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
                    this.$store.commit('pages/test_feature_list_delete/setFormValidate', value);
                }
            },
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(parent_id=0) {
                        let uri = '';
                        if (parent_id !== 0) {
                            uri = '/'+parent_id;
                        }
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/test_get_parents'+uri ).then(({ data }) => {
                            self.server_data = data;
                            self.data = data;
                            self.table.loading.state = false;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/test/'+id ).then(({ data }) => {
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    generate(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/test_generate_feature/'+id ).then(({ data }) => {
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    updateFeature(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/test_refresh_feature/'+id ).then(({ data }) => {
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                            self.$Message.error('could not update, see network');
                        });
                    }
                }
            },
            onCreateButtonClicked() {
                this.$router.push({ name: 'test_feature_create' });
            },
        },
        mounted() {

            this.ajax().get(this.parent_id);

        },
    }
</script>
