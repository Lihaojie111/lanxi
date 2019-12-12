<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"C:\wwwroot\lanxi.yz360.com.cn\public/../application/admin\view\user\user\moneylog.html";i:1573716758;s:72:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\layout\default.html";i:1573268565;s:69:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\common\meta.html";i:1573268565;s:71:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\common\script.html";i:1573268565;}*/ ?>
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
                                <div>
    <table id="table" class="table table-striped table-bordered table-hover" data-operate-edit="1" width="100%">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;" data-field="id">ID</th>
                <th style="text-align: center; vertical-align: middle;" data-field="id">变更余额</th>
                <th style="text-align: center; vertical-align: middle;" data-field="id">充值金额</th>
                <th style="text-align: center; vertical-align: middle;" data-field="id">赠送金额</th>
                <th style="text-align: center; vertical-align: middle;" data-field="id">状态</th>
                <th style="text-align: center; vertical-align: middle;" data-field="id">备注</th>
                <th style="text-align: center; vertical-align: middle;" data-field="id">时间</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td style="text-align: center; vertical-align: middle;" data-field="id"><?php echo $vo['id']; ?></td>
                <td style="text-align: center; vertical-align: middle;" data-field="id">￥<?php echo $vo['money']; ?></td>
                <td style="text-align: center; vertical-align: middle;" data-field="id">￥<?php echo $vo['cmoney']; ?></td>
                <td style="text-align: center; vertical-align: middle;" data-field="id">￥<?php echo $vo['zmoney']; ?></td>
                <td style="text-align: center; vertical-align: middle;" data-field="id"><?php if($vo['type'] == 1): ?>增加<?php else: ?>减少<?php endif; ?></td>
                <td style="text-align: center; vertical-align: middle;" data-field="id"><?php echo $vo['memo']; ?></td>
                <td style="text-align: center; vertical-align: middle;" data-field="id"><?php echo date('Y-m-d H:i',$vo['ctime']); ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>