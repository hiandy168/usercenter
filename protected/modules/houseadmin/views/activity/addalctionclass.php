<div class='bgf clearfix'>
    <div class="center_top clearfix">
        <ul>
            <li><a   class="btn btn-primary" href="javascript:history.go(-1);">返回</a></li>
        </ul>
    </div>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('Activity/addAlctionClass');?>" method="post">
            <input type="hidden" name="id" value="<?php echo isset($typeInfo['id'])?$typeInfo['id']:'';?>">
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td width='120' align="right">分类名称:</td>
                    <td>
                        <input  type="text" name="class_name" id="class_name"  class="required"  value="<?php echo $typeInfo['name'];?>" ><div style="float:left;" id="name_msg"></div>
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
