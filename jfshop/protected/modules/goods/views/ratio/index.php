<?php
$this->breadcrumbs=array(
    '商品管理',
    '商品积分比例管理',
    '设置商品积分比例'=>array('/goods/cat/index'),
);

?>
<div class="page-header">
    <h1>
        设置商品积分比例
    </h1>
</div>

<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" id="validation-form" novalidate="novalidate" action="?r=goods/ratio/<?php echo $action;?>" method="post">
            <div class="form-group">
                <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 比例分子 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5" name="numerator" value="<?php echo $arr['numerator'];?>">
                </div>
            </div>
            <div class="form-group">
                <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 比例分母 </label>
                <div class="col-sm-9">
                    <input type="text" class="col-xs-10 col-sm-5" name="denominator" value="<?php echo $arr['denominator'];?>">
                </div>
            </div>



            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info">
                        <i class="icon-ok bigger-110"></i>
                        提交
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button type="reset" class="btn">
                        <i class="icon-undo bigger-110"></i>
                        重置
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>