<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"C:\PHP\wamp64\www\fastadmin\public/../application/admin\view\goods\index\edit.html";i:1533213578;s:70:"C:\PHP\wamp64\www\fastadmin\application\admin\view\layout\default.html";i:1529292885;s:67:"C:\PHP\wamp64\www\fastadmin\application\admin\view\common\meta.html";i:1529292885;s:69:"C:\PHP\wamp64\www\fastadmin\application\admin\view\common\script.html";i:1529292885;}*/ ?>
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
    
    <input type="hidden" name="row[category_id]" value="<?php echo $row['category_id']; ?>">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
        <div class="form-inline col-xs-12 col-sm-8" data-toggle="cxselect" data-selects="first,second,third">
            <select class="first form-control" name="row[first]" data-url="ajax/category?type=goods&amp;pid=0">
                <option value="<?php echo $row['first']; ?>" selected=""></option>
            </select>
            <select class="second form-control" name="row[second]" data-url="ajax/category" data-query-name="pid">
                <option value="<?php echo $row['second']; ?>" selected=""></option>
            </select>
            <select class="third form-control" name="row[third]" data-url="ajax/category" data-query-name="pid">
                <option value="<?php echo $row['third']; ?>" selected=""></option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="<?php echo $row['title']; ?>">
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-category_id" data-rule="required" data-source="category/selectpage" data-params='{"custom[type]":"goods"}' class="form-control selectpage" name="row[category_id]" type="text" value="<?php echo $row['category_id']; ?>">
        </div>
    </div> -->

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Format type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-type" data-rule="required" class="form-control selectpicker" name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['type'])?$row['type']:explode(',',$row['type']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-type" data-rule="required" class="form-control selectpicker" name="row[type]">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['type'])?$row['type']:explode(',',$row['type']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    
    <div class="form-group">
        <label for="c-pic" class="control-label col-xs-12 col-sm-2"><?php echo __('Pic'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-pic" class="form-control" data-rule="required" size="50" name="row[pic]" type="text" value="<?php echo $row['pic']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-pic" class="btn btn-danger plupload" data-input-id="c-pic" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-pic"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-pic" class="btn btn-primary fachoose" data-input-id="c-pic" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-pic"></ul>
        </div>
    </div>
    
    <div class="form-group">
        <label for="c-pics" class="control-label col-xs-12 col-sm-2"><?php echo __('Pics'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-pics" class="form-control" data-rule="required" size="50" name="row[pics]" type="text" value="<?php echo $row['pics']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-pics" class="btn btn-danger plupload" data-input-id="c-pics" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-pics"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-pics" class="btn btn-primary fachoose" data-input-id="c-pics" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-pics"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sale_price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-sale_price" data-rule="required" class="form-control" step="0.01" name="row[sale_price]" type="number" value="<?php echo $row['sale_price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Market_price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-market_price" data-rule="required" class="form-control" step="0.01" name="row[market_price]" type="number" value="<?php echo $row['market_price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Cost_price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-cost_price" data-rule="required" class="form-control" step="0.01" name="row[cost_price]" type="number" value="<?php echo $row['cost_price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-description" class="form-control editor" rows="5" name="row[description]" cols="50"><?php echo $row['description']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Weight'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-weight" data-rule="required" class="form-control" name="row[weight]" type="number" value="<?php echo $row['weight']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Last_num'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-last_num" data-rule="required" class="form-control" name="row[last_num]" type="number" value="<?php echo $row['last_num']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Is_sale'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-is_sale" data-rule="required" class="form-control selectpicker" name="row[is_sale]">
                <?php if(is_array($isSaleList) || $isSaleList instanceof \think\Collection || $isSaleList instanceof \think\Paginator): if( count($isSaleList)==0 ) : echo "" ;else: foreach($isSaleList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['is_sale'])?$row['is_sale']:explode(',',$row['is_sale']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sort'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-sort" data-rule="required" class="form-control" name="row[sort]" type="number" value="<?php echo $row['sort']; ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>