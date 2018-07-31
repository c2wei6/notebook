<template>
    <div class="container">
        <mt-header title="待办事项">

        </mt-header>
        <div class="list-group">
            <mt-cell
                v-for="item in list"
                v-bind:key="item.id"
                v-bind:title="item.content"
                v-bind:class="{completed: item.status}">
                <input
                    type="checkbox"
                    v-bind:checked="item.status"
                    v-bind:disabled="item.status ? true : false"
                    v-on:click="complete(item.id)"
                >
            </mt-cell>
        </div>
        <div class="addBtn" v-on:click="addTodo">
            <i></i>
            <b></b>
        </div>
    </div>
</template>

<script>
    import { Header, Cell, Toast, MessageBox } from 'mint-ui';
    import axios from 'axios';
    export default {
        data() {
            return {
                list: [
                    {content: '内容', status: 0},
                ]
            }
        },
        created() {
            this.loadTodoList();
        },
        methods: {
            loadTodoList() {
                axios({
                    method: 'get',
                    url: '/api/gettodolist'
                }).then(res => {
                    if (res.status == 200) {
                        this.list = res.data.data;
                    }
                }).catch(e => {
                    Toast('服务器错误...');
                });
            },
            complete(index) {
                var event = window.event || arguments.callee.caller.arguments[0];
                var target = event.target || event.srcElement;
                MessageBox
                    .confirm('确定完成该任务？')
                    .then(action => {
                        if (action == 'confirm') {
                            axios({
                                method: 'post',
                                url: '/api/endtodo',
                                data: {id: index}
                            }).then(res => {
                                if (res.status == 200) {
                                    Toast('操作成功');
                                    this.loadTodoList();
                                }
                            }).catch(e => {
                                Toast('服务器错误...');
                            });
                        } else {
                            return false;
                        }
                    })
                    .catch(action => {
                        if (action == 'cancel') {
                            target.checked = false;
                        } else {
                            return false;
                        }
                    });
            },
            addTodo() {
                MessageBox
                    .prompt('请输入内容')
                    .then(({value, action}) => {
                        if (action == 'confirm') {
                            axios({
                                method: 'post',
                                url: '/api/settodo',
                                data: {content: value}
                            }).then(res => {
                                if (res.status == 200) {
                                    Toast('操作成功');
                                    this.loadTodoList();
                                }
                            }).catch(e => {
                                Toast('服务器错误...');
                            });
                        } else {
                            return false;
                        }
                    })
                    .catch(e => {
                        //
                    });
            }

        }
    }
</script>

<style>
    .completed .mint-cell-text {
        text-decoration: line-through;
    }

    div.addBtn {
        position: absolute;
        bottom: 70px;
        right: 15px;
        width: 50px;
        height: 50px;
        background-color: blue;
        border-radius: 25px;
    }

    div.addBtn i,
    div.addBtn b {
        position: absolute;
        left: 3px;
        top: 23px;
        display: inline-block;
        width: 44px;
        height: 4px;
        background-color: #fff;
        border-radius: 2px;
    }

    div.addBtn b {
        transform: rotate(90deg);
    }
</style>
