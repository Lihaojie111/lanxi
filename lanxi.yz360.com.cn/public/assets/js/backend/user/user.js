define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/user/index',
                    add_url: 'user/user/add',
                    // edit_url: 'user/user/edit',
                    del_url: 'user/user/del',
                    multi_url: 'user/user/multi',
                    table: 'user',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'user.id',
                columns: [
                    [
                        { checkbox: true },
                        { field: 'id', title: 'ID', sortable: true },
                        { field: 'username', title: __('Username'), operate: 'LIKE' },
                        { field: 'mobile', title: __('Mobile'), operate: 'LIKE' },
                        { field: 'avatar', title: __('Avatar'), events: Table.api.events.image, formatter: Table.api.formatter.image, operate: false },
                        { field: 'score', title: __('Score'), operate: 'BETWEEN', sortable: true },
                        { field: 'money', title: __('Money'), operate: 'BETWEEN', sortable: true },
                        {
                            field: 'first_leader',
                            width: "120px",
                            title: '一级盟友',
                            operate:false,
                            table: table,
                            events: Table.api.events.operate,formatter: Table.api.formatter.buttons, buttons: [
                                { name: 'first', text: '查看', title: '一级盟友列表', icon:'', classname: 'btn btn-xs btn-primary btn-dialog',url: 'user/user/first' },
                            ],
                        },
                        {
                            field: 'first_leader',
                            width: "120px",
                            title: '二级盟友',
                            operate:false,
                            table: table,
                            events: Table.api.events.operate,formatter: Table.api.formatter.buttons, buttons: [
                                { name: 'first', text: '查看', title: '二级盟友列表', icon:'', classname: 'btn btn-xs btn-primary btn-dialog',url: 'user/user/second' },
                            ],
                        },
                        {
                            field: 'first_leader',
                            width: "120px",
                            title: '三级盟友',
                            operate:false,
                            table: table,
                            events: Table.api.events.operate,formatter: Table.api.formatter.buttons, buttons: [
                                { name: 'first', text: '查看', title: '三级盟友列表', icon:'', classname: 'btn btn-xs btn-primary btn-dialog',url: 'user/user/third' },
                            ],
                        },
                        { field: 'jointime', title: __('Jointime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true },
                        {
                            field: 'status',
                            title: __('Status'),
                            operate:false,
                            formatter: Table.api.formatter.toggle,
                            searchList: {
                                normal: __('Normal'),
                                hidden: __('Hidden')
                            }
                        },
                        {
                            field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate, buttons: [
                                { name: 'recharge', text: '充值', title: '充值', icon: '', classname: 'btn btn-xs btn-primary btn-dialog', url: 'user/user/rechage' },
                                { name: 'consume', text: '消费', title: '消费', icon: '', classname: 'btn btn-xs btn-primary btn-dialog', url: 'user/user/consume' },
                                { name: 'withdrawal', text: '积分提现', title: '积分提现', icon: '', classname: 'btn btn-xs btn-primary btn-dialog', url: 'user/user/withdrawal' },
                                {name: 'adress', text: '余额日志', title: '余额日志', icon: '', classname: 'btn btn-xs btn-primary btn-dialog', url:'user/user/moneylog'},
                                {name: 'score', text: '积分日志', title: '积分日志', icon: '', classname: 'btn btn-xs btn-primary btn-dialog', url:'user/user/scorelog'}
                            ],
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
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