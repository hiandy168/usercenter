<div class='bgf clearfix'>



    <div class="form_list">
        <form name="formview" id="formview" action="" method="post">
            <input type="hidden" id="activity_id" name="activity_id" value="<?php echo isset($activity_id)?$activity_id:'';?>">
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td width='120' align="right">应&nbsp;&nbsp;用:</td>
                    <td>
                        <select id="pid" name="pid" style="width:155px">
                            <option value="0">--无--</option>
                            <?php
                            $pid = isset($pid)?$pid:0;
                            if($project) {
                                foreach ($project as $val) {
                                    ?>
                                    <option
                                        value="<?php echo $val['id'] ?>" <?php echo $pid == $val['id'] ? 'selected' : ''; ?>><?php echo $val['name'] ?></option>
                                <?php }
                            }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">启用:</td>
                    <td>
                        <label for="status1" class='w_30'>启用</label> <input class='w_30'  id='status1' type="radio" name="status" value="1" <?php if(!isset($result['status'])||$result['status']==1){echo 'checked';} ?> />

                        <label for="status0" class='w_30'>禁用</label> <input  class='w_30' id='status0' type="radio" name="status" value="2" <?php if(isset($result['status'])&&$result['status']==2){echo 'checked';} ?>  />
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
    $("#pid").change(function(){
        var pid=$("#pid").val();
        var activity_id=$("#activity_id").val();

        window.location.href="<?php echo $this->createUrl('activity/ProjectManager/activity_id')?>/"+activity_id+"/pid/"+pid;
    })
</script>