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
    <div class="definition_list_delete">
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
                            <Select v-model="filters.project_name.selected" @on-change="onFilterSelected('project_name')" multiple style="width:260px" placeholder="--nothing selected--">
                                <div slot="prefix" class="table-filters-slot-prefix"><strong>project_name: </strong></div>
                                <Option v-for="item in filters.project_name.data" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        </div>
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
                },
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
            if (this.$store.state.pages.definition_list_delete) 
            {
                state = this.$store.state.pages.definition_list_delete;
            }
            var self = this;


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
                server_data: [],
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
            },
            filters: {
                deep: true,
                handler(value) 
                {
                    this.$store.commit('pages/definition_list_delete/setFilters', value);
                }
            },
            data: {
                deep: true,
                handler: function(value) {
                    let tmp_table = new Map();
                    for (const i in value) {
                        if (value.hasOwnProperty(i)) {
                            const element = value[i];
                            tmp_table.set(element.project_name, {
                                'label': element.project_name,
                                'value': element.project_name,
                            });
                        }
                    }

                    this.filters.project_name.data = Array.from(tmp_table.values());
                }
            }
        },
        methods: {
            ajax() {
                var self = this;
                return {
                    get(id='') {
                        window.axios.get( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/definition'+id ).then(({ data }) => {
                            self.server_data = data;
                            self.data = data;
                            self.table.loading.state = false;
                            self.setFiltersToTable();
                        }).catch(error => {
                            console.log(error);
                        });
                    },
                    delete(id) {
                        window.axios.delete( process.env.MIX_BASE_RELATIVE_URL_BACKEND+'/trident/resource/definition/'+id ).then(({ data }) => {
                            window.location.reload();
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }
            },
            onCreateButtonClicked() {
                this.$router.push({ name: 'definition_create' });
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

        }
    }
</script>
