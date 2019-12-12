define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'card/index/index' + location.search,
                    add_url: 'card/index/add',
                    edit_url: 'card/index/edit',
                    del_url: 'card/index/del',
                    multi_url: 'card/index/multi',
                    table: 'card',
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
                        {field: 'id', title:'ID'},
                        {field: 'name', title: '名称'},
                        {field: 'cat.name', title: '卡片类别', operate: false},
                        {field: 'img', title: __('Img'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false },
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'shiji', title: '实际到账', operate:'BETWEEN'},
                        {field: 'status', title: '状态',operate: false,formatter: Table.api.formatter.toggle},
                        {field: 'ctime', title:'添加时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime, operate: false },
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