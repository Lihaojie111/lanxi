define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'product/index/index' + location.search,
                    add_url: 'product/index/add',
                    edit_url: 'product/index/edit',
                    del_url: 'product/index/del',
                    multi_url: 'product/index/multi',
                    table: 'product',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: 'ID'},
                        {field: 'name', title: __('Name')},
                        {field: 'cat.name', title: '产品分类'},
                        {field: 'img', title: '图片',events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false},
                        {field: 'introduce', title: __('Introduce')},
                        {field: 'price', title: __('Price')},
                        {field: 'status', title: '状态',operate: false,formatter: Table.api.formatter.toggle},
                        {field: 'is_index', title: '首页显示',operate: false,formatter: Table.api.formatter.toggle},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});