<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <ul>
            <li><a   class="btn btn-primary" href="javascript:history.go(-1);">返回</a></li>
        </ul>
    </div>

    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('Activity/Addactivity');?>" method="post">
            <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td width='120' align="right">分&nbsp;&nbsp;类:</td>
                    <td>
                        <select id="cid" name="cid" style="width:155px">
                            <option value="0">--无--</option>
                            <?php
                            $cid = isset($result['cid'])?$result['cid']:0;
                            if($model) {
                                foreach ($model as $val) {
                                    ?>
                                    <option
                                        value="<?php echo $val['id'] ?>" <?php echo $cid == $val['id'] ? 'selected' : ''; ?>><?php echo str_repeat('&nbsp;&nbsp;', $val['count'] - 1) . "|---"; ?><?php echo $val['class_name'] ?></option>
                                <?php }
                            }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">组件名称:</td>
                    <td>
                        <input  type="text" name="activity_name" id="activity_name"  class="required"  value="<?php echo isset($result['activity_name'])?$result['activity_name']:'';?>" ><div style="float:left;" id="name_msg"></div>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">组件表名:</td>
                    <td>
                        <input  type="text" name="activity_table_name" id="activity_table_name"  class="required"  value="<?php echo isset($result['activity_table_name'])?$result['activity_table_name']:'';?>" ><div style="float:left;" id="name_msg"></div>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">最佳显示:</td>
                    <td>
                    <label for="status1" class='w_30'>PC</label> <input class='w_30'  id='status1' type="radio" name="see_status" value="1" <?php if(!isset($result['see_status'])||$result['see_status']==1){echo 'checked';} ?> />

                    <label for="status0" class='w_30'>微信</label> <input  class='w_30' id='status0' type="radio" name="see_status" value="2" <?php if(isset($result['see_status'])&&$result['see_status']==2){echo 'checked';} ?>  />

                    <label for="status0" class='w_30'>全部</label> <input  class='w_30' id='status0' type="radio" name="see_status" value="3" <?php if(isset($result['see_status'])&&$result['see_status']==3){echo 'checked';} ?>  />
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">状态:</td>
                    <td>
                        <label for="status1" class='w_30'>启用</label> <input class='w_30'   type="radio" name="status" value="1" <?php if(!isset($result['status'])||$result['status']==1){echo 'checked';} ?> />

                        <label for="status0" class='w_30'>禁用</label> <input  class='w_30'  type="radio" name="status" value="2" <?php if(isset($result['status'])&&$result['status']==2){echo 'checked';} ?>  />

                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">组件logo地址:</td>
                    <td>
                        <input  type="text" name="activity_img" id="activity_img"  value="<?php echo isset($result['activity_img'])?$result['activity_img']:'';?>" ><div style="float:left;" id="name_msg"></div>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">禁用组件logo地址:</td>
                    <td>
                        <input  type="text" name="activity_nouse_img" id="activity_nouse_img"  value="<?php echo isset($result['activity_nouse_img'])?$result['activity_nouse_img']:'';?>" ><div style="float:left;" id="name_msg"></div>
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

