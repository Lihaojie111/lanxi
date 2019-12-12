<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"C:\wwwroot\lanxi.yz360.com.cn\public/../application/admin\view\user\user\withdrawal.html";i:1574066362;s:72:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\layout\default.html";i:1573268565;s:69:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\common\meta.html";i:1573268565;s:71:"C:\wwwroot\lanxi.yz360.com.cn\application\admin\view\common\script.html";i:1573268565;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <div class="form-group">
        <input id="id" data-rule="" size="50" type="hidden" value="<?php echo $id; ?>">
        <!-- <div class="box">
                <label for="c-avatar" class="control-label col-xs-12 col-sm-2">消费金额:</label>
                <div class="col-xs-12 col-sm-4">
                    <input id="money" data-rule="required" class="form-control" name="row[money]" type="number" value="">
                </div>
        </div> -->

        <div class="form-group">
            <label for="c-money" class="control-label col-xs-12 col-sm-2">提现积分:</label>
            <div class="col-xs-12 col-sm-4">
                <input id="score" data-rule="" class="form-control" name="row[score]" type="number" value="<?php echo $score; ?>"
                    autocomplete="">
            </div>
        </div>
        <!-- <div class="form-group layer-footer"> -->
            <label class="control-label col-xs-12 col-sm-2"></label>
            <div class="col-xs-12 col-sm-8">
                <div  id="btn1" class="btn btn-success btn-embossed">确定提现</div>
                <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
            </div>
        <!-- </div> -->
    </div>
</form>

<script src="/assets/js/jquery.js"></script>
<script type="text/javascript">
    $("#btn1").click(function () {
        var score = $('#score').val();
        var id = $('#id').val();
        // alert(score);
        // return false;
        layer.confirm('确定提现积分吗？',
            {
                icon: 3,
                title: '温馨提示',
                yes: function (index) {
                    $.ajax({
                        url: '<?php echo url("saveScore"); ?>',
                        type: 'post',
                        dataType: 'json',
                        data: { 'score': score, 'id': id },
                        success: function (res) {
                            if (res.code == 1) {
                                parent.location.reload();
                            } else {
                                layer.msg(res.msg,{icon:2,time:2000});
                            }
                        }
                    })
                    layer.close(index);
                },
                cancel: function (index, layero) {
                    layer.close(index);
                    return false;
                }
            });


    });
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