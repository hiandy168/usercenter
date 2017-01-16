<style>
    .clear { clear: both; height: 0; overflow: hidden;}
    .mat5 { margin-top: 5px;}
    .fl { float: left;}
    .fr { float: right;}
    .mat10 { margin-top: 10px;}
    .rule_id {
        border: 1px dashed #ccc;
        border-radius: 2px;
        display: block;
        float: left;
        height: 28px;
        line-height: 28px;
        margin: 5px 5px 0 0;
        padding: 0 10px;
    }
    a.js_add {
        background: none repeat scroll 0 0 #5cb85c;
        border-radius: 2px;
        color: #f5f5f5;
        display: block;
        float: left;
        font-family: "宋体";
        font-size: 14px;
        font-weight: bold;
        height: 30px;
        line-height: 30px;
        text-align: center;
        width: 120px;
    }

</style>
<div class='bgf clearfix'>

    <div class="center_top clearfix">

    </div>


    <div class="clearfix"></div>

    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/product/' . $fun); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
            <table cellSpacing=0 width="98%" class="content_view">
                <tr>
                    <td class="t"><?php echo Mod::t('admin', 'selecttype') ?></td>
                    <td colspan='4'>

                        <select name="category_id"  class="required" id="category_id">
                            <option value=""><?php echo Mod::t('admin', 'select') ?></option>
                            <?php if (!empty($categoryarr)) {
                                foreach ($categoryarr as $category) { ?>
                                    <option value="<?php echo $category['id'] ?>"<?php if (isset($view['category_id']) && $view['category_id'] == $category['id']): ?>selected<?php endif; ?>>
                                    <?php echo $category['name'] ?>
                                    </option>
    <?php }
} ?>
                        </select>

                    </td>
                    <td rowspan="3" class="thumb" width="200" >
                        <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb', 'picture')" src="<?php echo isset($view['picture']) ? (Tool::show_img($view['picture'])) : (Tool::show_img('')) ?>" width="176" height='123' width="150" id="img_thumb">
                        <input type="hidden" name="picture" id="picture" value="<?php echo isset($view['picture']) ? $view['picture'] : ''; ?>">
                        <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                            <span  class="btn btn-danger" onclick="upload_pic('img_thumb', 'picture')"><?php echo Mod::t('admin', 'upload_pic') ?></span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="t">商品编号</td>
                    <td  colspan='4'>
                        <input type="text" name="code" id="code" class="required"  size='50' value="<?php echo isset($view['code']) ? $view['code'] : ''; ?>">
                    </td>
                </tr><tr>
                    <td class="t">商品名称</td>
                    <td  colspan='4'>
                        <input type="text" name="title" id="title" class="required"  size='50' value="<?php echo isset($view['title']) ? $view['title'] : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="t">商品描述</td>
                    <td  colspan='5'><textarea rows="5" cols="55" class="txtarea" name="description" id="description"><?php echo isset($view['description']) ? $view['description'] : ''; ?></textarea></td></tr>
                </tr>
                <tr>
                    <td class="t">商品价格</td>
                    <td  colspan='5'>
                        <input type="text" name="price" id="price" class="required"  size='50' value="<?php echo isset($view['price']) ? $view['price'] : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="t">电商价格</td>
                    <td  colspan='5'>
                        <input type="text" name="eprice" id="eprice" class="required"  size='50' value="<?php echo isset($view['eprice']) ? $view['eprice'] : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="t">库存</td>
                    <td  colspan='5'>
                        <input type="text" name="num" id="num" class="required"  size='50' value="<?php echo isset($view['num']) ? $view['num'] : ''; ?>">
                    </td>
                </tr>  <tr>
                    <td class="t">商品规格</td>
                    <td colspan="5">
                        <div style="width:700px" class="fl">
<?php $i = 1;foreach ($specarr as $s) { ?>
                                <label style="width: 110px;  <?php if(in_array($s['id'],$view['spec_arr'])){ echo 'checked="checked"';}?>" rule_id="<?php echo $s['id']; ?>" name="<?php echo $s['title'] ?>" class="rule_id">
                                    <input type="checkbox" name="sku_arr[]"  value='<?php echo $s['id'] ?>'  <?php if(in_array($s['id'],$view['spec_arr'])){ echo 'checked="checked"';}?> > <?php echo $s['title'] ?>
                                </label>
<?php $i++;} ?>
                            <div class="clear"></div>
                        </div>
                        <div class="fr table_td mat5"><a class="js_add" href="javascript:;">增加选项</a></div>
                        <div class="clear"></div>
                        <table width="100%" class="mat10" id="prorule_html">
                            <tbody>

                                <tr>
                                   <?php $i = 1;foreach ($specarr as $s) { ?> 
                                    <td width="100" class="bgtt" id="<?php echo $s['id'];?>" style="display: none;">
                                        <?php echo $s['title']?><input type="hidden" value="<?php echo $s['id'];?>" name="rule_id[]">
                                    </td>
                                    <?php $i++;} ?>
                                   
                                    <td width="60" class="table_td bgtt" style="display:none;">本店价</td>
                                    <td width="60" class="table_td bgtt" style="display:none;">市场价</td>
                                    <td width="60" class="table_td bgtt" style="display:none;">库存</td>
                                    <td width="50" class="table_td bgtt" style="display:none;">操作</td>
                                </tr>
                                
                                <?php 
                                if(isset($pro_spec)&&!empty($pro_spec)){foreach($pro_spec as $sku){ 
                                ?>
                                
                                <tr>
                                    <?php $i = 1;foreach ($specarr as $s) { ?> 
                                    <td style="display: table-cell;">
                                        <select class="inputselect" name="spec[<?php echo $s['id'];?>][]">
                                            <option value="">请选择</option>
                                          <?php foreach($s['element'] as $e) { ?>
                                            <option value="<?php echo $e['id'];?>" <?php $sku_product_spec_arr = explode(',',$sku['product_spec']);if(in_array($e['id'],$sku_product_spec_arr)){ echo 'selected="selected"';}?> ><?php echo $e['name'];?></option>
                                            <?php } ?>
  
                                        </select>
                                    </td>
                                    <?php $i++;} ?>
                        
                                    </td>
                                    <td class="table_td" style="display: table-cell;"><input type="text" class="inputtext input50" value="<?php echo $sku['product_money']?>" name="product_money[]"></td>
                                    <td class="table_td" style="display: table-cell;"><input type="text" class="inputtext input50" value="<?php echo $sku['product_smoney']?>" name="product_smoney[]"></td>
                                    <td class="table_td" style="display: table-cell;"><input type="text" class="inputtext input50" value="<?php echo $sku['product_num']?>" name="product_num[]"></td>
                                    <td class="table_td" style="display: table-cell;"><a class="js_del" href="javascript:;">删除</a></td>
                                </tr>
                                <?php 
                                            }} 
                                            ?>
                                
                                <tr style="display:none">
				    <?php $i = 1;foreach ($specarr as $s) { ?> 
                                    <td style="display: table-cell;">
                                        <select class="inputselect" name="spec[<?php echo $s['id'];?>][]">
                                            <option value="">请选择</option>
                                            <?php foreach($s['element'] as $e) { ?>
                                                        <option value="<?php echo $e['id'];?>"><?php echo $e['name'];?></option>
                                            <?php } ?>
  
                                        </select>
                                    </td>
                                    <?php $i++;} ?>
                       
					<td class="table_td" style="display: table-cell;"><input type="text" class="inputtext input50" name="product_money[]"></td>
					<td class="table_td" style="display: table-cell;"><input type="text" class="inputtext input50" name="product_smoney[]"></td>
					<td class="table_td" style="display: table-cell;"><input type="text" class="inputtext input50" name="product_num[]"></td>
					<td class="table_td" style="display: table-cell;"><a class="js_del" href="javascript:;">删除</a></td>
				</tr>
                             
                            </tbody></table>
                    </td>
                </tr>


                <tr>
                    <td class="t"><?php echo Mod::t('admin', 'content') ?></td>
                    <td  colspan='5'><textarea style="width:650px;height:300px;" name="content" id="content" class="editor"><?php echo isset($view['content']) ? htmlspecialchars($view['content']) : ''; ?></textarea></td></tr>
    <!--	 <tr>
                <td class="t"><?php echo Mod::t('admin', 'tpl') ?></td>
                    <td><input type="text" name="tpl" id="tpl"  value="<?php echo isset($view['tpl']) ? $view['tpl'] : ''; ?>"></td>
                </tr>-->
                <tr>
                    <td class="t"><?php echo Mod::t('admin', 'copyfrom') ?></td>
                    <td><input type="text" name="copyfrom" id="copyfrom"  value="<?php echo isset($view['copyfrom']) ? $view['copyfrom'] : ''; ?>"></td>
                    <td class="t"><?php echo Mod::t('admin', 'auther') ?></td>
                    <td  colspan='3'><input type="text" name="auther" id="auther" size="52"  value="<?php echo isset($view['auther']) ? $view['auther'] : '' ?>"></td>
                </tr>
                <tr>
                    <td class="t"><?php echo Mod::t('admin', 'hits') ?></td>
                    <td><input type="text" name="hits" id="hits"   value="<?php echo isset($view['hits']) ? $view['hits'] : 0 ?>"></td>
                    <td class="t"><?php echo Mod::t('admin', 'createtime') ?></td>
                    <td colspan='3'><input type="text" name="createtime" id="createtime"   size="52" value="<?php echo isset($view['createtime']) ? date('Y-m-d H:i:s', $view['createtime']) : date('Y-m-d H:i:s') ?>"></td>
                </tr>
                <tr>
                    <td class="t"><?php echo Mod::t('admin', 'order') ?></td>
                    <td><input type="text" name="order" id="order" value="<?php if (isset($view['order'])) {
    echo $view['order'];
} else {
    echo '99';
} ?>" ></td>
                </tr>
                <tr>
                    <td class="t">类型</td>
                    <td>
                        <label  class='w_10'>顶置</label>
                        <input  class='w_30' type="checkbox" name="typefor[top]" value='1' <?php
                        if (isset($view['top']) && ($view['top'] == 1)) {
                            echo 'checked';
                        }
                        ?> />
                        <label  class='w_10'>焦距</label>
                        <input  class='w_30' type="checkbox" name="typefor[focus]" value='1' <?php
                        if (isset($view['focus']) && ($view['focus'] == 1)) {
                            echo 'checked';
                        }
                        ?> />
                        <label class='w_10'>推荐</label>
                        <input  class='w_30' type="checkbox" name="typefor[recommend]"  value='1'  <?php
                        if (isset($view['recommend']) && $view['recommend'] == 1) {
                            echo 'checked';
                        }
                        ?>  />
                        <label  class='w_10'>精选</label>
                        <input  class='w_30' type="checkbox" name="typefor[choiceness]"  value='1'  <?php
                        if (isset($view['choiceness']) && $view['choiceness'] == 1) {
                            echo 'checked';
                        }
                        ?> />
                        <label class='w_10'>热点</label>
                        <input  class='w_30' type="checkbox" name="typefor[hot]"  value='1'  <?php
                                if (isset($view['hot']) && $view['hot'] == 1) {
                                    echo 'checked';
                                }
                                ?>  />
                    </td>
                    <td class="t"></td><td></td>
                </tr>

                <tr>
                    <td class="t"><?php echo Mod::t('admin', 'status') ?></td>
                    <td colspan='3'> 
                        <label  class='w_10'> <?php echo Mod::t('admin', 'yes') ?></label>
                        <input  class='w_30' type="radio" name="status" value="1" <?php
                                if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                }
                                ?> />
                        <label class='w_10'> <?php echo Mod::t('admin', 'no') ?></label>
                        <input  class='w_30' type="radio" name="status" value="0" <?php
                                if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                }
                                ?>  />
                    </td>
                    <td class="t"></td><td></td>
                </tr>
                <tr>
                    <td width='80' align='right' style="border:none"></td>
                    <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                    <td width='80' align='right' style="border:none"></td>
                </tr>
            </table>
        </form>

    </div>

</div>   

<script type="text/javascript" charset="utf-8">

    $("label").click(function() {
        if ($(this).find(":input").is(":checked")) {
            $(this).css("background", "#faf18f");
        }
        else {
            $(this).css("background", "#fff")
        }
        prorule_html_show();
    })
    $(":checkbox").each(function() {
        if ($(this).is(":checked")) {
            $(this).parent("label").css("background", "#faf18f");
        }
    })
    function prorule_html_show() {
        var i = 0;
        $(".rule_id").each(function() {
            var rule_id = $(this).attr("rule_id");
            if ($(this).find(":input").is(":checked")) {
                i++;
                $("#" + rule_id).show().find("input").removeAttr("disabled");
                $(":input[name='spec[" + rule_id + "][]']").parent("td").show().find("input").removeAttr("disabled");
            }
            else {
                $("#" + rule_id).hide().find("input").attr("disabled", "disabled");
                $(":input[name='spec[" + rule_id + "][]']").parent("td").hide().find("input").attr("disabled", "disabled");
            }
        })
        if (i > 0) {
            $(".table_td").show();
        }
        else {
            $(".table_td").hide();
        }
    }
    $(".js_add").click(function() {
        //alert($(this).parents("tr").html());
        var tr_clone = $("#prorule_html tr:last").clone(false);
        tr_clone.show();
        $("#prorule_html").append(tr_clone);
    })
    $(".js_del").on("click", function() {
        $(this).parent().parent("tr").remove();
    })
    $(function() {
        prorule_html_show();
        $(":button").click(function() {
            var kong_num = rule_num = 0;
            if ($(":input[name='rule_idarr[]']:checked").length > 0) {
                $("#prorule_html").find(":input").each(function() {
                    if ($(this).attr("disabled") == "disabled" || $(this).is(":hidden"))
                        return true;
                    if ($(this).val() == '') {
                        kong_num++;
                    }
                    else {
                        rule_num++;
                    }
                })
                if (rule_num == 0) {
                    alert('您勾选的规格名称，但未增加规格属性...');
                    return;
                }
                if (kong_num > 0) {
                    alert('规格属性尚未填写完全');
                    return;
                }
            }
            $("form").submit();
        })
    })

</script>

