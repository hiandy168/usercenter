<style>
    .modal-body{overflow-y: hidden;}
    .modal-dialog{width: 60%;}
    .nav-list > li.active:after{border-style:none;}
</style>
<script>
    var  siteurl = "<?php echo $this->_siteUrl;?>";
</script>
<link rel="stylesheet" href="<?php echo Mod::app()->theme->baseUrl; ?>/kindeditor-4.1.10/themes/default/default.css" />
<link rel="stylesheet" href="<?php echo Mod::app()->theme->baseUrl; ?>/kindeditor-4.1.10/plugins/code/prettify.css" />

<script charset="utf-8" src="<?php echo Mod::app()->theme->baseUrl; ?>/kindeditor-4.1.10/kindeditor.js"></script>
<script charset="utf-8" src="<?php echo Mod::app()->theme->baseUrl; ?>/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script charset="utf-8" src="<?php echo Mod::app()->theme->baseUrl; ?>/kindeditor-4.1.10/plugins/code/prettify.js"></script>
<div class="row">
    <div class="col-xs-12">
        <form id="validation-form" action="?r=goods/default/<?php echo $action;?>" class="form-horizontal" method="post" novalidate="novalidate">
            <div class="billContainer">
                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">商品名</label>
                    <div class="col-sm-9">
                        <input type="text" class="col-xs-12 col-sm-5" value="<?php echo isset($model['goods_row'])?$model['goods_row']['name']:'';?>" name="Goods[name]" id="name">
                        <input type="hidden" name="goods_id" id="goods_id" value="<?php echo isset($model['goods_row'])?$model['goods_row']['goods_id']:'';?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">商品分类</label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo isset($model['cat_row'])?$model['cat_row']:'';?>" id="goods_cat" class="col-xs-10 col-sm-5" readonly="">
                        <input type="hidden" id="goods_cat_id" value="<?php echo isset($model['goods_row'])?$model['goods_row']['cat_id']:'';?>" name="Goods[cat_id]">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">商品类型</label>
                    <div class="col-sm-3">
                        <select id="type_id" class="form-control" name="Goods[type_id]">
                            <option value="">请选择</option>
                            <?php if (isset($model['type']) && $model['type']):?>
                                <?php foreach ($model['type'] as $k=>$v):?>
                                    <option value="<?php echo $k;?>" <?php echo isset($model['goods_row'])&&$model['goods_row']['type_id']==$k?'selected':'';?>>
                                        <?php echo $v;?>
                                    </option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">商品编号</label>
                    <div class="col-sm-3">
                        <input type="text" name="Goods[bn]" value="<?php echo isset($model['goods_row'])?$model['goods_row']['bn']:'';?>" class="col-sm-5">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">商品关键词</label>
                    <div class="col-sm-3">
                        <input type="text" name="Keywords" value="<?php echo isset($model['keywords'])?$model['keywords']:'';?>" class="col-sm-5">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">品牌</label>
                    <div class="col-sm-3">
                        <select id="brand_id" class="form-control" name="Goods[brand_id]">
                            <option value="">请选择</option>
                            <?php if (isset($model['brand']) && $model['brand']):?>
                            <?php foreach ($model['brand'] as $k=>$v):?>
                                <option value="<?php echo $v['brand_id'];?>" <?php echo isset($model['goods_row'])&&$model['goods_row']['brand_id']==$v['brand_id']?'selected':'';?>>
                                    <?php echo $v['brand_name'];?>
                                </option>
                            <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment" class="control-label col-xs-12 col-sm-3 no-padding-right">商品简介：</label>

                    <div class="col-xs-12 col-sm-9">
                        <div class="clearfix">
                            <textarea  class="input-xlarge" name="Goods[brief]"><?php echo isset($model['goods_row'])?$model['goods_row']['brief']:'';?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">默认图片</label>
                    <div class="col-sm-7">
                        <div class="ace-file-input ace-file-multiple">
                            <div class="col-sm-3">
                                <label data-title="选择图片" class="file-label">
                                    <span data-title="No File ..." class="file-name">
                                         <i class="upload-icon icon-cloud-upload blue icon-3x" id="file_upload"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment" class="control-label col-xs-12 col-sm-3 no-padding-right">相册：</label>
                    <div class="col-xs-12 col-sm-9">
                        <input type="hidden" name="Goods[image_default_id]" id="image-default" value="<?php echo isset($model['goods_row'])?$model['goods_row']['image_default_id']:'';?>">
                        <ul class="ace-thumbnails">
                            <?php if (isset($model['image']) && $model['image']):?>
                            <?php foreach ($model['image'] as $v):?>
                            <li>
                                <a data-rel="colorbox" title="商品图片" href="<?php echo $this->_siteUrl.'\\'.$v['l_url'];?>" class="cboxElement">
                                    <img style="width: 120px;height: 120px;" src="<?php echo $this->_siteUrl.'\\'.$v['s_url'];?>">
                                    <input type="hidden" name="Image[]" value="<?php echo $v['ident'];?>">
                                    <input type="hidden" name="ImageId[]" class="image-id" value="<?php echo $v['image_id'];?>">
                                    <?php if ($v['image_id'] == $model['goods_row']['image_default_id']):?>
                                    <div class="tags image_default">
                                        <span class="label-holder">
                                            <span class="label label-danger">默认图片</span>
                                        </span>
                                    </div>
                                    <?php endif;?>
                                    <div class="text">
                                        <div class="inner">点击查看大图</div>
                                    </div>
                                </a>
                                <div class="tools tools-bottom">
                                    <button class="btn btn-minier btn-purple arrowed-right image_default_opt" data="<?php echo $v['image_id'];?>">默认</button>
                                    <button class="btn btn-minier btn-pink arrowed image_delete_opt" imgid="<?php echo $v['image_id'];?>" data="<?php echo $v['image_id']==$model['goods_row']['image_default_id']?'true':'false'?>">删除</button>
                                </div>
                            </li>
                            <input type="hidden" name="ImageAttach[]" value="<?php echo $v['image_id'];?>">
                            <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="billContainer no_spec">
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 销售价 </label>
                    <div class="col-sm-1">
                        <input type="text" placeholder="销售价格" name="Goods[price]" value="<?php echo isset($model['goods_row'])?sprintf('%.2f',$model['goods_row']['price']):''?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 成本价 </label>
                    <div class="col-sm-1">
                        <input type="text" placeholder="成本价" name="Goods[cost]" value="<?php echo isset($model['goods_row'])?sprintf('%.2f',$model['goods_row']['cost']):''?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 市场价 </label>
                    <div class="col-sm-1">
                        <input type="text" placeholder="市场价" name="Goods[mktprice]" value="<?php echo isset($model['goods_row'])?sprintf('%.2f',$model['goods_row']['mktprice']):''?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 重量 </label>
                    <div class="col-sm-1">
                        <input type="text" class="col-sm-7" placeholder="重量" name="Goods[weight]" value="<?php echo isset($model['goods_row'])?$model['goods_row']['weight']:''?>">
                        <span class="help-inline col-sm-5">
                            <span class="middle">(g)</span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 库存 </label>
                    <div class="col-sm-1">
                        <input type="text" class="col-sm-7" placeholder="库存" name="Goods[store]" value="<?php echo isset($model['goods_row'])?$model['goods_row']['store']:''?>">
                    </div>
                </div>
            </div>

            <div class="billContainer no_spec">
                <?php if($action !='create'){;?>
                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">支付类型</label>
                    <div class="col-sm-3">
                        <label>
                            <input type="radio" class="ace" name="Goods[paytype]" value="1" <?php echo isset($model['goods_row']['paytype'])&&$model['goods_row']['paytype']==1?'checked':'';?>>
                            <span class="lbl">现金</span>
                        </label>
                        <label>
                            <input type="radio" class="ace" name="Goods[paytype]" value="2" <?php echo isset($model['goods_row']['paytype'])&&$model['goods_row']['paytype']==2?'checked':'';?>>
                            <span class="lbl">货到付款</span>
                        </label>
                        <label>
                            <input type="radio" class="ace" name="Goods[paytype]" value="3" <?php echo isset($model['goods_row']['paytype'])&&$model['goods_row']['paytype']==3?'checked':'';?>>
                            <span class="lbl">积分</span>
                        </label>
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">计量单位</label>
                    <div class="col-sm-3">
                        <input type="text" value="<?php echo isset($model['goods_row']['unit'])?$model['goods_row']['unit']:'';?>" name="Goods[unit]" class="col-sm-5">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">立即上架</label>
                    <div class="col-sm-3">
                        <label>
                            <input type="radio" class="ace" name="Goods[marketable]" value="true" <?php echo isset($model['goods_row']['marketable'])&&$model['goods_row']['marketable']=="true"?'checked':'';?>>
                            <span class="lbl">是</span>
                        </label>
                        <label>
                            <input type="radio" class="ace" name="Goods[marketable]" value="false" <?php echo isset($model['goods_row']['marketable'])&&$model['goods_row']['marketable']=="false"?'checked':'';?>>
                            <span class="lbl">否</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 详细说明 </label>
                    <div class="col-sm-9">
                        <div class="col-xs-8">
                            <textarea name="Goods[intro]" id="intro"><?php echo isset($model['goods_row'])?$model['goods_row']['intro']:'';?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="Goods[is_spec]" value="<?php echo isset($model['goods_row']['is_spec'])&&$model['goods_row']['is_spec']?$model['goods_row']['is_spec']:'false';?>" id="is_spec">
            <input type="hidden" name="Goods[is_props]" value="<?php echo isset($model['goods_row']['is_props'])&&$model['goods_row']['is_props']?$model['goods_row']['is_props']:'false';?>" id="is_props">

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info">
                        <i class="icon-ok bigger-110"></i>
                        提交
                    </button>
                    <button type="reset" class="btn">
                        <i class="icon-undo bigger-110"></i>
                        重置
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">

    KindEditor.ready(function(K) {
        var editor1 = K.create('#intro', {
            width : '800px',
            height : '300px',
            cssPath : '<?php echo Mod::app()->theme->baseUrl; ?>/kindeditor-4.1.10/plugins/code/prettify.css',
            uploadJson : siteurl+'/admin.php?r=site/filejson',
            allowFileManager : true
        });
        prettyPrint();
    });
</script>