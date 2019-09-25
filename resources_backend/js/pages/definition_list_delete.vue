<style scoped>
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
</style>
<template>
    <div class="definition_list_delete">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">

                <Row type="flex" justify="end" style="margin-bottom: 20px;">
                    <Col>
                        <Button type="primary" @click="on_create_button_clicked">Create</Button>
                    </Col>
                </Row>

                <Row>
                    <Col>
                        <Table border :loading="table.loading.state" :columns="columns" :data="data" no-data-text="-no data-">
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
            if (this.$store.state.pages.definition_list_delete) 
            {
                state = this.$store.state.pages.definition_list_delete;
            }


            //
            //component state registration
            return {
                ...local,
                ...state,
                columns: [
                    {
                        title: 'project_id',
                        key: 'project_id',
                        minWidth: 100,
                    },
                    {
                        title: 'namespace',
                        key: 'namespace',
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
                                            this.$router.push({ name: 'definition_update', params: { id: row.id } });
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
                                }, 'Delete')
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
                    this.$store.commit('pages/definition_list_delete/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/definition'+id ).then(({ data }) => {
                            // console.log(data);
                            self.data = data;
                            self.table.loading.state = false;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/definition/'+id ).then(({ data }) => {
                            // console.log(data);
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }
            },
            on_create_button_clicked() {
                this.$router.push({ name: 'definition_create' });
            },
        },
        mounted() {

            this.ajax().get();

        },
    }
</script>
