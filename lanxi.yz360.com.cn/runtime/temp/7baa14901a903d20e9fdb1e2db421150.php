<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:83:"C:\wwwroot\lanxi.yz360.com.cn\public/../application/admin\view\dashboard\index.html";i:1574062633;s:72:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\layout\default.html";i:1573268565;s:69:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\common\meta.html";i:1573268565;s:71:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\common\script.html";i:1573268565;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <style type="text/css">
    .sm-st {
        background: #fff;
        padding: 20px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        margin-bottom: 20px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
    }

    .sm-st-icon {
        width: 60px;
        height: 60px;
        display: inline-block;
        line-height: 60px;
        text-align: center;
        font-size: 30px;
        background: #eee;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        float: left;
        margin-right: 10px;
        color: #fff;
    }

    .sm-st-info {
        font-size: 12px;
        padding-top: 2px;
    }

    .sm-st-info span {
        display: block;
        font-size: 24px;
        font-weight: 600;
    }

    .orange {
        background: #fa8564 !important;
    }

    .tar {
        background: #45cf95 !important;
    }

    .sm-st .green {
        background: #86ba41 !important;
    }

    .pink {
        background: #AC75F0 !important;
    }

    .yellow-b {
        background: #fdd752 !important;
    }

    .stat-elem {

        background-color: #fff;
        padding: 18px;
        border-radius: 40px;

    }

    .stat-info {
        text-align: center;
        background-color: #fff;
        border-radius: 5px;
        margin-top: -5px;
        padding: 8px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        font-style: italic;
    }

    .stat-icon {
        text-align: center;
        margin-bottom: 5px;
    }

    .st-red {
        background-color: #F05050;
    }

    .st-green {
        background-color: #27C24C;
    }

    .st-violet {
        background-color: #7266ba;
    }

    .st-blue {
        background-color: #23b7e5;
    }

    .stats .stat-icon {
        color: #28bb9c;
        display: inline-block;
        font-size: 26px;
        text-align: center;
        vertical-align: middle;
        width: 50px;
        float: left;
    }

    .stat {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        margin-right: 10px;
    }

    .stat .value {
        font-size: 20px;
        line-height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
    }

    .stat .name {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat.lg .value {
        font-size: 26px;
        line-height: 28px;
    }

    .stat.lg .name {
        font-size: 16px;
    }

    .stat-col .progress {
        height: 2px;
    }

    .stat-col .progress-bar {
        line-height: 2px;
        height: 2px;
    }

    .item {
        padding: 30px 0;
    }
</style>
<?php if(preg_match('/\/admin\/|admin\.php|admin_d75KABNWt\.php/i', url())): ?>
<div class="alert alert-danger-light">
    <?php echo __('Security tips'); ?>
</div>
<?php endif; ?>
<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#one" data-toggle="tab"><?php echo __('Dashboard'); ?></a></li>
            <!-- <li><a href="#two" data-toggle="tab"><?php echo __('Custom'); ?></a></li> -->
        </ul>
    </div>
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">

                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-users"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $userCount; ?></span>
                                <?php echo __('Total user'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet"><i class="fa fa-book"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $proCount; ?></span>
                                <?php echo __('总产品数'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-blue"><i class="fa fa-shopping-bag"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $orderCount; ?></span>
                                <?php echo __('总预约量'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-green"><i class="fa fa-cny"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $moneyCount; ?></span>
                                <?php echo __('Total order amount'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:15px;">

                    <div class="col-lg-12">
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-blue">
                            <div class="panel-body">
                                <div class="panel-title">
                                    <span class="label label-success pull-right"><?php echo __('Real time'); ?></span>
                                    <h5><?php echo __('总服务统计'); ?></h5>
                                </div>
                                <div class="panel-content">
                                    <h1 class="no-margins"><?php echo $serviceCount; ?></h1>
                                    <div class="stat-percent font-bold text-gray"><i class="fa fa-commenting"></i>
                                        <?php echo $serviceNum; ?>
                                    </div>
                                    <small><?php echo __('当前可用服务'); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-aqua-gradient">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <span class="label label-info pull-right"><?php echo __('Real time'); ?></span>
                                    <h5><?php echo __('消息统计'); ?></h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins"><?php echo $msgCount; ?></h1>
                                    <div class="stat-percent font-bold text-gray"><i class="fa fa-modx"></i> <?php echo $msgNum; ?>
                                    </div>
                                    <small><?php echo __('当前启用的消息'); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-purple-gradient">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-right"><?php echo __('Real time'); ?></span>
                                    <h5><?php echo __('卡片统计'); ?></h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h1 class="no-margins"><?php echo $cardNum; ?></h1>
                                            <div class="font-bold"><i class="fa fa-commenting"></i>
                                                <small><?php echo __('当前可用卡片'); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <div class="panel bg-green-gradient">
                            <div class="panel-body">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-right"><?php echo __('Real time'); ?></span>
                                    <h5><?php echo __('技师统计'); ?></h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h1 class="no-margins"><?php echo $techNum; ?></h1>
                                            <div class="font-bold"><i class="fa fa-commenting"></i>
                                                <small><?php echo __('当前可用技师'); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h1 class="no-margins"><?php echo $techInfo['name']; ?></h1>
                                            <div class="font-bold"><i class="fa fa-user"></i>
                                                <small><?php echo __('预约量最高的技师'); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo __('最新预约'); ?></h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    <?php if(is_array($orderInfo) || $orderInfo instanceof \think\Collection || $orderInfo instanceof \think\Paginator): if( count($orderInfo)==0 ) : echo "" ;else: foreach($orderInfo as $key=>$vo): ?>
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="<?php echo $vo['avatar']; ?>" style="height:40px;width:40px;">
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-title">
                                                <?php echo $vo['username']; ?>
                                                <span class=" pull-right">
                                                    <?php if($vo['status'] == 1): ?>
                                                    <font color="green">预约成功</font>
                                                    <?php elseif($vo['status'] == 2): ?>
                                                    <font color="blue">服务完成</font>
                                                    <?php else: ?>
                                                    <font color="red">已取消</font>
                                                    <?php endif; ?>
                                                </span>
                                            </a>
                                            <span class="product-description">
                                                <?php echo $vo['servicename']; ?>
                                            </span>
                                        </div>
                                    </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo __('最新消息'); ?></h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <?php if(is_array($msgInfo) || $msgInfo instanceof \think\Collection || $msgInfo instanceof \think\Paginator): if( count($msgInfo)==0 ) : echo "" ;else: foreach($msgInfo as $key=>$vo): ?>
                                    <li><a href="#"><?php echo $vo['title']; ?><span class="pull-right text-red"><?php echo date('Y-m-d H:i',$vo['ctime']); ?></span></a></li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo __('Server info'); ?></h3>
                            </div>
                            <div class="box-body" style="padding-top:0;">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td width="140" Height="50px" style="vertical-align:middle;">系统版本</td>
                                            <td style="vertical-align:middle;"><?php echo \think\Config::get('fastadmin.version'); ?> <a
                                                    href="javascript:;" class="btn btn-xs btn-checkversion"></a></td>
                                        </tr>
                                        <tr>
                                            <td Height="50px" style="vertical-align:middle;"><?php echo __('Timezone'); ?></td>
                                            <td style="vertical-align:middle;"><?php echo date_default_timezone_get(); ?></td>
                                        </tr>
                                        <tr>
                                            <td Height="50px" style="vertical-align:middle;">当前语言</td>
                                            <td style="vertical-align:middle;"><?php echo $config['language']; ?></td>
                                        </tr>
                                        <tr>
                                            <td Height="50px" style="vertical-align:middle;">当前管理员</td>
                                            <td style="vertical-align:middle;"><?php echo $adminInfo['nickname']; ?></td>
                                        </tr>
                                        <tr>
                                            <td Height="50px" style="vertical-align:middle;">当前登录IP</td>
                                            <td style="vertical-align:middle;"><?php echo $adminInfo['loginIp']; ?></td>
                                        </tr>
                                        <tr>
                                            <td Height="50px" style="vertical-align:middle;">当前登录时间</td>
                                            <td style="vertical-align:middle;"><?php echo date('Y-m-d
                                                H:i:s',$adminInfo['logintime']); ?></td>
                                        </tr>
                                    </tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="two">
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo __('Custom zone'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var Orderdata = {
        column: {: json_encode(array_keys($paylist))
    },
        paydata: {: json_encode(array_values($paylist)) },
        createdata: {: json_encode(array_values($createlist)) },
    };
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>