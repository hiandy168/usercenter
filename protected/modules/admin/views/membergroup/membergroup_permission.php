
<div class='bgf clearfix'>
          
<div class="center_top clearfix">
<ul>
    <li><a  class="btn btn-primary"  href="javascript:;">权限设置</a></span>  </li>
</ul>

</div>
    
     
<div class="clearfix"></div>
<div class="list">                     
<form name="list_frm" id="ListFrm" action="<?php echo $this->createUrl('membergroup/permission');?>" method="post">
<input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
  <table width="100%" cellspacing="0">
		<thead>
			<tr> 
			  <th  width="350">人员权限</th>
                          <th  width="350">内部操作</th>
                          <!--<th>子栏目</th>-->
                          <th></th>
			</tr>
		</thead>
		<tbody>
        <tr>
            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >
            <select id="member_permission" name="permission_id">
                <option value="0">请选择</option>
                <option <?php if($view['permission_id'] == 1){echo 'selected="selected"';}?> value="1">全部</option>
                <option <?php if($view['permission_id'] == 2){echo 'selected="selected"';}?> value="2">部分</option>
<!--                <option --><?php //if($view['permission_id'] == 3){echo 'selected="selected"';}?><!-- value="3">个人</option>-->
            </select>
            </td>
            <td id="permission_text" style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >
                <input type="text" name="addpermissionmember" id="shousuo" placeholder="搜索人员"/>
<!--                --><?php //if($view['permission_id']==1){ ?>
<!--                    全部-->
<!--               --><?php //}else if($view['permission_id']==2){ ?>
<!--                    <input type="text" name="addpermissionmember" id="shousuo" placeholder="搜索人员"/>-->
<!--               --><?php //} ?>
            </td>
        </tr>
<!--                            <tr>-->
<!--                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" ></td>-->
<!--                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" ></td>-->
<!--                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >-->
<!--                                <input id="sub"  --><?php //if($view['permission_id']==2){ echo 'style="display:none"';}?><!-- type="submit" value='提交' class="btn btn-success">-->
<!---->
<!--                            </td>-->
<!--                            </tr>-->
		</tbody>
	</table>


    <table id="admingroup" width="100%" cellspacing="0">
        <thead>

        <tr>已添加:</tr>
        <tr>
            <th width="350">手机号</th>
            <th width="350">姓名</th>
            <?php if($view['permission_id']==2){?><th width="350">是否为组长</th><?php }?>
            <th width="350">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($view['permission'])){foreach ($view['permission'] as $v){?>
        <tr>
            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $v['phone'];?></td>
            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $v['username'];?></td>
            <?php if($view['permission_id']==2){?><td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php if($v['status']==1){echo "是";}else{echo "否";};?></td><?php }?>
            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
            <?php if($view['permission_id']==2){?><a class='a_edit' onclick="issetadmin(<?php echo $v['id'];?>)"  href="#">编辑</a><?php } ?>
                <a class='a_del' onclick="delmember(<?php echo $v['id'];?>)" href="javascript:;">删除</a>
            </td>

        </tr>
        <?php }} ?>
        </tbody>
    </table>
<!--      <div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"><?php echo Mod::t('admin','all') ?></li>
        </ul>
    </div>-->
   </form>
</div>


</div>

 </div>   
<script>
    $("#member_permission").change(function () {
        var member_permission = $("#member_permission").val();
        var permission_id = <?php echo $view['permission_id'];?>;
        if(member_permission != permission_id){
//            $("#sub").attr("style","display:block");
            $("#admingroup").attr("style","display:none");
        }else{
            window.location.reload();
        }

    })

    $("#permission_text").on("keyup","input[type=text]",function(){
        var member_permission = $("#member_permission").val();

        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl("membergroup/membervalidate") ?>",
            data:{
                phone: $("input[type=text]").val(),
                id: <?php echo $view['id'];?>,
                permission_id:member_permission
            },
            dataType:"json",
            success: function(data){
                $("#permission_text span").remove();
                //alert(msg);
                if(data.status == 200){
                    console.log(data.data);
                    $("#shousuo").after('<span>该账号可添加<input type="button" onclick="addmemberpermission('+data.data+','+member_permission+')" value="添加" class="btn btn-success"></span> ');
                    //alert("操作成功");
//                    window.location.reload();//刷新当前页面
                }else if(data.status == 404){
                    $("#shousuo").after("<span>"+data.msg+"</span>");
//                    alert("审核失败");
                }else {
                    $("#shousuo").after("<span>改账号不存在</span>");
//                    alert("审核失败");
                }
            }
        });
    })


    function addmemberpermission(id,permission_id){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl("membergroup/addmemberpermission") ?>",
            data:{
                id:<?php echo $view['id'];?>,
                mid: id,
                permission_id:permission_id,
            },
            dataType:"json",
            success: function(data){
                if(data.status == 200){
                    console.log(data.data);
                    window.location.reload();//刷新当前页面
//
//                    alert(data.msg,function(){
//                                            window.location.reload();//刷新当前页面
//                    });
//                    window.location.reload();//刷新当前页面
                }
            }
        });
    }


    function issetadmin(id) {
        if(confirm('确定要设置组长么')) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl("membergroup/addmembergroupadmin") ?>",
                data: {
                    id:<?php echo $view['id'];?>,
                    mid: id,
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == 200) {
                        console.log(data.data);
                        window.location.reload();//刷新当前页面

                    }
                }
            });
        }
    }
    
    function delmember(id){
        if(confirm('确定要删除么')) {
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl("membergroup/delmember") ?>",
                data: {
                    id:<?php echo $view['id'];?>,
                    mid: id,
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == 200) {
                        console.log(data.data);
                        window.location.reload();//刷新当前页面

                    }
                }
            });
        }
    }


</script>
