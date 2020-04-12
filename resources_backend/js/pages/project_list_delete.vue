<style scoped>
    .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
    .table-filters {
        margin-bottom: 20px;
    }
        .table-filters-slot-prefix {
            padding-right: 200px;
        }
            .table-filters-slot-prefix > strong {
                margin-bottom: 2px;
            }
</style>
<template>
    <div class="project_list_delete">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">

                <Row type="flex" justify="end" style="margin-bottom: 20px;">
                    <Col>
                        <Button type="primary" @click="onCreateButtonClicked">Create</Button>
                    </Col>
                </Row>

                <Row type="flex">
                    <Col span="1" style="width: 80px; text-align: center;">
                        Filters: 
                        <Divider style="margin: 2px; 0px;" />
                        <Button type="default" size="small" @click  ="onClearAllButtonClicked">clear all</Button>
                    </Col>
                    <Col span="1" style="width: 10px; height: 53px;">
                        <Divider type="vertical" style="height: 53px; margin-left:0px;" />
                    </Col>
                    <Col>
                        <div class="table-filters">
                            <Select v-model="filters.name.selected" @on-change="onFilterSelected('name')" multiple style="width:260px" placeholder="--nothing selected--">
                                <div slot="prefix" class="table-filters-slot-prefix"><strong>name: </strong></div>
                                <Option v-for="item in filters.name.data" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        </div>
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
                        state: true,
                        text: 'loading',
                    },
                }
            };

            var state = {
                formValidate: {
                },
                filters: {
                    name: {
                        selected: [],
                        data: [],
                    },
                }
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
                        maxWidth: 200,
                    },
                    {
                        title: 'root_folder',
                        key: 'root_folder',
                        minWidth: 100,
                        maxWidth: 200,
                    },
                    {
                        title: 'relative_schemas_folder',
                        key: 'relative_schemas_folder',
                        minWidth: 100,
                        maxWidth: 200,
                    },
                    {
                        title: 'db_connection_name',
                        key: 'db_connection_name',
                        minWidth: 200,
                        maxWidth: 200,
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
                server_data: [],
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
            },
            filters: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/project_list_delete/setFilters', value);
                }
            },
            data: {
                deep: true,
                handler: function(value) {
                    let tmp_table = new Map();
                    for (const i in value) {
                        if (value.hasOwnProperty(i)) {
                            const element = value[i];
                            tmp_table.set(element.name, {
                                'label': element.name,
                                'value': element.name,
                            });
                        }
                    }

                    this.filters.name.data = Array.from(tmp_table.values());
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project'+id ).then(({ data }) => {
                            self.server_data = data;
                            self.data = data;
                            self.table.loading.state = false;
                            self.setFiltersToTable();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/project/'+id ).then(({ data }) => {
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    make(id) {
                        return window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/project_make/'+id ).then(({ data }) => {
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
                        }).catch(error => {
                            console.log(error);
                            self.$Message.error('could not make, see network');
                        });
                    },
                }
            },
            onCreateButtonClicked() {
                this.$router.push({ name: 'project_create' });
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
            setFiltersToTable() {
                let filters = this.filters;

                for (const key in filters) {
                    if (filters[key].selected.length > 0) {
                        this.onFilterSelected(key);
                    }
                }
            },
            onFilterSelected(column_name) {
                let server_data = this.server_data;
                let selected_filters = this.filters[column_name].selected;
                let tmp_array = [];

                for (const i in server_data) {
                    if (server_data.hasOwnProperty(i)) {
                        const element = server_data[i];

                        if (selected_filters.includes(element[column_name])) {
                            tmp_array.push(element);
                        }
                    }
                }

                if (tmp_array.length > 0) {
                    this.data = tmp_array;
                } else {
                    this.data = server_data;
                }
            }
        },
        mounted() {
            
            this.ajax().get();

        },
    }
</script>
