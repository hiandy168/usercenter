<?php $this->load->view('header');?>
<style>
    #pics ul li{float:left;width:165px;height:240px;margin:5px;padding:5px;border:1px solid #e6e6e6;text-align:left;position:relative;}
    #pics ul .img{float:left;height:140px;max-width:140px;}
    #pics ul .img img{height:140px;max-width:140px;}
    #pics ul .del{width:20px;margin:0 0 0 5px;position:absolute;right:0}
    #pics ul .del span{display:block;float:left;}
    #pics ul .del span:hover{cursor:pointer;color:#ff0000}
    #pics ul .order{margin:5px 0;float:left;width:140px}
    #pics ul .order span{float:left;}
    #pics ul .order input{float:left;width:40px}
    #pics ul .text{float:left;}
    #pics ul .text span{float:left;}
    #pics ul .text textarea{float:left;width:110px;height:60px}
</style>


<div class='bgf clearfix'>



    <div class="form_list">
    <form action="<?php echo admin_url('pic/pics_edit')?>" method="post" id="EditFrm" name="edit_frm">
        <input type="hidden" name="id" value="<?php echo $view['id']?>" />
        <div id="pics">
            <ul>
               
                <?php if(isset($pic_list)){foreach($pic_list as $pic){ ?>
                <li>
                    <input type='hidden' value="<?php echo $pic['picture'] ?>" name="pic[<?php echo $pic['id'] ?>][pics]">
                    <div class='img'><img src="<?php echo show_img($pic['picture']) ?>" id="img1" ></div>
                    <div class="del"> <p><input type='checkbox' value="<?php echo $pic['id'] ?>" name='pic[id]'></p><span onclick="del_picture('<?php echo $pic['id'] ?>');">删<br>除<br>该<br>图</span></div>
                    <div class="order"><span>排序：</span><input  type='text' value="<?php echo $pic['order'] ?>" name="pic[<?php echo $pic['id'] ?>][order]"></div>
                    <div class="text"><span>描述：</span><textarea  name="pic[<?php echo $pic['id'] ?>][title]" ><?php echo $pic['title'] ?></textarea></div>
                </li>
                <?php }} ?>
            </ul>
        </div>
        <br>
        <div style="clear:both;">

            <p> <label><input type='checkbox'  id="idAll" onclick="checkall(this,'pic[id]')">全选</label>&nbsp;&nbsp;
                <input type='button' class="btn_a" onclick="del_picture();" value="删除选中的图片"></p>
             <br>
            <p>
                <input type="button" class="btn_a" onclick="upload_pic_bat()"   value="上传图片/批量上传" />&nbsp;&nbsp;&nbsp;&nbsp;
                <input  type="submit" class="btn_a" name="save" value=提&nbsp;交 /></p>
           
            <div>
                </form>
            </div>
           
            <SCRIPT type="text/javascript">

                function del_picture(id){
                        if(id == undefined){
                             var arr = new Array();
                               $("input[name='pic[id]']:checked").each(function() {
//                                     if ($(this).checked == true){
                                         arr.push($(this).val());
//                                     }              
                                });
                               var ids = arr.join(',');
                        }else{
                           var ids = id;
                        }
                        var url = "<?php echo admin_url('pic/pics_del') ?>";    
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data:{ids:ids},
                            dataType: 'json',
                            timeout: 10000,
                            error: function(){alert('Error Comment');},
                            success: function(data){
                                if(data){
                                   location.reload();
                                }else{
                                    alert('删除出错');
                                    location.reload();
                                }
                            }
                        });                      
                }
            </SCRIPT>
            