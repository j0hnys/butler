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
    <div class="index">
        <Row type="flex" justify="center" align="middle">
            <Col span="24">
                <h1>
                    Hi!
                </h1>

                <h2>
                    <p>
                        This is an Implementation Manager for laravel applications made with Trident and Vista.
                        <br>
                        Click the "Projects" menu item on the top left to get started    
                    </p>
                    <p>
                        Build something cool. :)
                    </p>
                </h2>
            </Col>
        </Row>
    </div>
</template>

<script>
    import HelloType, { Dict, Enum, Tuple, List, Type, Rule, Self, IfExists } from 'hello-type'
    import TypeChecker from '../types/TypeChecker.js';

    export default {
        data() {
            var state = {
                variable: '',
            };
            if (this.$store.state.pages.Index) 
            {
                state = this.$store.state.pages.Index;
            }


            return {
                ...state,
            };
        },
        types: {
            namespace: 'test/test/test',
            schema() {
                return new Type({
                    variable: String,
                });
            }
        },
        methods: {
        },
        mounted() {
            this.$global_events.$on('pages/Index/test',(data) => {
                console.log('pages/Index/test global event fired with data: "'+data+'"');    
            });


            TypeChecker.checkNamespace('ena/dyo/tria',{
                name: '1',
                age: 11,
                nested: [
                    {
                        parameter_one: 1,
                        parameter_two: 1,
                    },
                    {
                        parameter_one: 1,
                        parameter_two: 1,
                    },
                ],
            });

        },
    }
</script>
