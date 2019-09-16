<style scoped>
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
</style>
<template>
    <div class="project_list_delete">
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
import { setTimeout } from 'timers';
    export default {
        data() {
            var local = {
                table: {
                    loading: {
                        state: false,
                        text: 'loading',
                    },
                }
            };

            var state = {
                formValidate: {
                },
            };
            if (this.$store.state.pages.project_list_delete) 
            {
                state = this.$store.state.pages.project_list_delete;
            }


            //
            //component state registration
            return {
                ...local,
                ...state,
                columns: [
                    {
                        title: 'name',
                        key: 'name',
                        minWidth: 100,
                    },
                    {
                        title: 'root_folder',
                        key: 'root_folder',
                        minWidth: 100,
                    },
                    {
                        title: 'relative_schemas_folder',
                        key: 'relative_schemas_folder',
                        minWidth: 100,
                    },
                    {
                        title: 'db_connection_name',
                        key: 'db_connection_name',
                        minWidth: 200,
                        maxWidth: 300,
                    },
                    {
                        title: 'Action',
                        key: 'action',
                        maxwidth: 250,
                        minwidth: 250,
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
                                            this.$router.push({ name: 'project_update', params: { id: row.id } });
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
                                            this.table.loading.text = 'making...';
                                            this.ajax().make(row.id).then(() => {
                                                this.table.loading.state = false;
                                            });
                                        }
                                    }
                                }, 'Make'),
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
                    this.$store.commit('pages/project_list_delete/setFormValidate', value);
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project'+id ).then(({ data }) => {
                            // console.log(data);
                            self.data = data;
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project/'+id ).then(({ data }) => {
                            // console.log(data);
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    make(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_make/'+id ).then(({ data }) => {
                            // self.$Message.success('Success!');
                            self.$Notice.success({
                                render: h => {
                                    return h('pre', {
                                        style: {
                                            overflow: 'hidden'
                                        },
                                    }, [
                                        'go to your new project and run:\n 1. `composer update`\n 2. `npm install`\n 3. `php artisan key:generate`\n 4. edit `.env` if needed'
                                    ]);
                                },
                                duration: 10000
                            });
                            // window.location.reload();
                        }).catch(error => {
                            console.log(error);
                            self.$Message.error('could not make, see network');
                        });
                    },
                }
            },
            on_create_button_clicked() {
                this.$router.push({ name: 'project_create' });
            },
        },
        mounted() {
            // console.log('test list mounted');
            // console.log({
            //     // 'this.$store': this.$store,
            //     // 'this.$store.state': this.$store.state,
            //     // 'this.$store.state.Index': this.$store.state.Index,
            //     'this.$route': this.$route,
            // });

            this.ajax().get();

        },
    }
</script>
