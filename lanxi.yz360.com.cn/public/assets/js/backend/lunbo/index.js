define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'lunbo/index/index' + location.search,
                    add_url: 'lunbo/index/add',
                    edit_url: 'lunbo/index/edit',
                    del_url: 'lunbo/index/del',
                    multi_url: 'lunbo/index/multi',
                    table: 'lunbo',
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
                        {field: 'title', title: __('Title')},
                        {field: 'type', title: '类别', operate: false},
                        {field: 'service.name', title: '所属服务', operate: false},
                        {field: 'img', title: __('Img'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false },
                        {field: 'status', title:'状态',operate: false,formatter: Table.api.formatter.toggle},
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