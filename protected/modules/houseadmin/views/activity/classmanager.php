<div class='bgf clearfix'>



    <div class="form_list">
        <form name="formview" id="formview" action="" method="post">
            <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td width='120' align="right">分&nbsp;&nbsp;类:</td>
                    <td>
                        <select id="cid" name="cid" style="width:155px">
                            <option value="0">--无--</option>
                            <?php
                            $cid = isset($cid)?$cid:0;
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
                    <td width='120' align="right">组&nbsp;&nbsp;件:</td>
                    <td>
                        <?php  if($activity){foreach ($activity as $val){?>
                        <input type="checkbox" <?php if(in_array($val['id'],$relation)){ echo 'checked';} ?> id="<?php echo $val['activity_table_name'];?>" name="activity_id[]" value="<?php echo $val['id'];?>"><?php echo $val['activity_name'];?>
                        <?php }}?>
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

<script>
        $("#cid").change(function(){
            var cid=$("#cid").val();
            window.location.href="<?php echo $this->createUrl('activity/classmanager/cid')?>/"+cid;
        })
</script>