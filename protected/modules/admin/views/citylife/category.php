<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <ul>
            <li><span><a class="btn btn-primary" href="javascript:;">添加/编辑城市服务分类</a></span></li>
        </ul>
    </div>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/citylife/'.$fun,array('action'=>isset($model->id)?'edit':'add'));?>" method="post">
            <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:'';?>">
            <table cellSpacing=0 width="100%" class="content_view">

                <tr>
                    <td width='120' class="t">分类名称<em style="color:#ff0000">*</em>&nbsp;:</td>
                    <td>
                        <input  type="text" name="name" id="name" class="required"  size="20"   value="<?php echo isset($model->name)?$model->name:'';?>" >
                    </td>
                </tr>

                <tr>
                    <td width='120' class="t">排序<em style="color:#ff0000">*</em>&nbsp;:</td>
                    <td>
                        <input  type="text" name="position" id="position"  value="<?php echo isset($model->position)?$model->position:'99';?>" >
                        <div id="name_msg"></div>
                    </td>
                </tr>
<!--                二级分类-->
<!--                <tr>-->
<!--                    <td width='120' class="t">父类ID<em style="color:#ff0000">*</em>&nbsp;:</td>-->
<!--                    <td>-->
<!--                        <select name="fid" id="fid"></select>-->
<!--                        <option value="0">一级分类</option>-->
<!--                        --><?php //foreach($fids as $v){
//                            //如果$v->id  输出表中所有fid = $v->id的数据
//                            ?>
<!---->
<!--                        --><?php //} ?>
<!--                    </td>-->
<!--                </tr>-->

                <tr>
                    <td width='120' align='right'>服务状态:</td>
                    <td>
                        <label for="status1" class='w_30'>启用</label> <input class='w_30'  id='status1' type="radio" name="status" value="1" <?php if(!isset($model->status)||$model->status==1){echo 'checked';} ?> />

                        <label for="status0" class='w_30'>禁用</label> <input  class='w_30' id='status0' type="radio" name="status" value="0" <?php if(isset($model->status)&&$model->status==0){echo 'checked';} ?>  />
                    </td>
                </tr>
                <tr>
                    <td width='120' align='right' style="border:none"></td>
                    <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
