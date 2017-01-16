<div class="row">
    <div class="col-xs-12" style="margin-left: 10px;">
        <form class="form-horizontal" action="?r=goods/cat/<?php echo $action;?>" method="post">
            <div class="form-group">
                <label for="form-field-1" class="col-sm-3 control-label no-padding-right">分类名称</label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo isset($model['cat_row']['cat_name'])?$model['cat_row']['cat_name']:'';?>" name="Cat[cat_name]" class="col-xs-10 col-sm-5" placeholder="分类名称" id="form-field-1">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">上级分类</label>
                <div class="col-sm-3">
                    <select id="goods_type" class="form-control" name="Cat[parent_id]">
                        <option value="">---无---</option>
                        <?php if (isset($model['parent']) && $model['parent']):?>
                            <?php foreach ($model['parent'] as $k=>$v):?>
                                <option value="<?php echo $v['cat_id'];?>" <?php echo isset($model['cat_row'])&&$model['cat_row']['parent_id']==$v['cat_id']?'selected':'';?>>
                                    <?php if ($v['path'] == 2):?>
                                        &nbsp;&nbsp;&nbsp;-&nbsp;-
                                    <?php endif;?>
                                    <?php if ($v['path'] == 3):?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;-&nbsp;-&nbsp;-
                                    <?php endif;?>
                                    <?php echo $v['cat_name'];?>
                                </option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="control-label col-xs-12 col-sm-3 no-padding-right">商品类型</label>
                <div class="col-sm-3">
                    <select id="goods_type" class="form-control" name="Cat[type_id]">
                        <option value="">请选择</option>
                        <?php if (isset($model['type']) && $model['type']):?>
                            <?php foreach ($model['type'] as $k=>$v):?>
                                <option value="<?php echo $k;?>" <?php echo isset($model['cat_row'])&&$model['cat_row']['type_id']==$k?'selected':'';?>><?php echo $v;?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 排序 </label>
                <div class="col-sm-5">
                    <input type="text" class="col-sm-1" name="Cat[p_order]"
                           value="<?php echo isset($model['cat_row']['p_order'])&&$model['cat_row']['p_order']?$model['cat_row']['p_order']:'99';?>">
                </div>
            </div>

            <!--
            <div class="form-group">
                <label for="form-field-1" class="col-sm-3 control-label no-padding-right">分类图片</label>
                <div class="col-sm-9">
                    <a id="bootbox-regular" class="btn">上传图片</a>
                    <div id="cat-img" style="margin-top: 10px;">
                        <img style="width: 150px;height: 150px;" src="<?php echo isset($model['cat_row']['img_url'])?Common::ImgUrlName($model['cat_row']['img_url'],'m'):'/images/image-2.jpg';?>">
                        <input type="hidden" name="Cat[img_url]" value="<?php echo isset($model['cat_row']['img_url'])?$model['cat_row']['img_url']:'';?>">
                    </div>
                </div>
            </div>
            -->

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info">
                        <i class="icon-ok bigger-110"></i>
                        确认
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>