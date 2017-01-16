<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <ul>
            <li><a   class="btn btn-primary" href="javascript:history.go(-1);">返回</a></li>
        </ul>
    </div>

    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('Activity/addclass');?>" method="post">
            <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td width='120' align="right">分类名称:</td>
                    <td>
                        <input  type="text" name="class_name" id="class_name"  class="required"  value="<?php echo isset($result['class_name'])?$result['class_name']:'';?>" ><div style="float:left;" id="name_msg"></div>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">上级分类:</td>
                    <td>
                        <select id="" name="parent_id" style="width:155px">
                            <option value="0">--无--</option>
                            <?php
                            $pid = isset($result['parent_id'])?$result['parent_id']:0;
                            foreach($model as $val){
                                ?>
                                <option value="<?php echo $val['id']?>" <?php echo $pid==$val['id'] ? 'selected' : '';?>><?php  echo  str_repeat('&nbsp;&nbsp;', $val['count']-1)."|---";?><?php echo $val['class_name']?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">分类logo:</td>
                    <td>
                        <input  type="text" name="class_logo" id="class_logo"  class="required"  value="<?php echo isset($result['class_logo'])?$result['class_logo']:'';?>" ><div style="float:left;" id="name_msg"></div>
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
