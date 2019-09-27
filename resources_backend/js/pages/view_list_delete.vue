<style scoped>
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
</style>
<template>
    <div class="view_list_delete">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">

                <Row type="flex" justify="end" style="margin-bottom: 20px;">
                    <Col>
                        <Button type="primary" @click="on_create_button_clicked">Create</Button>
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
            };
            if (this.$store.state.pages.view_list_delete) 
            {
                state = this.$store.state.pages.view_list_delete;
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
                        maxWidth: 150,
                    },
                    {
                        title: 'definition_namespace',
                        key: 'definition_namespace',
                        maxWidth: 190,
                    },
                    {
                        title: 'entity_name',
                        key: 'entity_name',
                        maxWidth: 150,
                    },
                    {
                        title: 'name',
                        key: 'name',
                        maxWidth: 100,
                    },
                    {
                        title: 'type',
                        key: 'type',
                        maxWidth: 100,
                    },
                    {
                        title: 'vista_resource_folder_name',
                        key: 'vista_resource_folder_name',
                        minWidth: 100,
                    },
                    {
                        title: 'Action',
                        key: 'action',
                        maxWidth: 300,
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
                                            this.$router.push({ name: 'view_update', params: { id: row.id } });
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
                                    on: {
                                        click: () => {
                                            this.table.loading.state = true;
                                            this.table.loading.text = 'generating...';
                                            this.ajax().generate(row.id).then(() => {
                                                this.table.loading.state = false;
                                            });
                                        }
                                    }
                                }, 'Generate')
                            ]);
                        }
                    }
                ],
                data: []


            };
        },
        watch: {
            formValidate: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/view_list_delete/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/view'+id ).then(({ data }) => {
                            self.data = data;
                            self.table.loading.state = false;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/view/'+id ).then(({ data }) => {
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    generate(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/view_generate/'+id ).then(({ data }) => {
                            self.$Message.success('Success!');
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }
            },
            on_create_button_clicked() {
                this.$router.push({ name: 'view_create' });
            },
        },
        mounted() {

            this.ajax().get();

        },
    }
</script>
