<style> 
.form {
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #4686c6;
    margin: 10px auto;
    width:98%;margin:20px auto;
}
.form table {
    width: 100%;
}
.form input, .form select, .form textarea {
}
.form tbody td {
    border-bottom: 1px solid #c2d1d8;
    border-right: 1px solid #c2d1d8;
    padding: 4px 5px;
    text-align: left;
}
.form tbody td.t {
    background: none repeat scroll 0 0 #f2f8ff;
    text-align: right;
}
.form tbody td.table_foot {
    background: none repeat scroll 0 0 #e7f0fb;
    text-align: center;
}
.form tbody td label.w_30, .form tbody td input.w_30 {
    float: left;
    width: 30px;
}
.form tbody td label.w_10, .form_list tbody td input.w_10 {
    float: left;
    width: 10px;
}

.sub_table thead{line-height:30px;height:30px;text-align:left;background:#E5E5E5;color:#333;}
.sub_table thead th{color:#333;font-weight:normal;padding-left:10px;}
.sub_table tbody tr td{border:0;border-bottom: 1px solid #cccccc;}
</style>  
<div class='bgf clearfix'>
          

            <div class="clearfix"></div>
            
 
            
            <div class="form" style=''>
                  <form onsubmit="" method="post" action="<?php echo $this->createUrl('spec/'.$fun) ?>" id="formview" name="save">
                      <input type="hidden" value="<?php echo isset($view['id'])?$view['id']:''?>" name="id" > 
                        <table width="100%" cellspacing="0" class="content_view">  
                        <tbody>
                     
                        <tr>
                            <td  width='120' class="t"> 规格名称:</td>
                            <td>
                                <input style='width:220px'  type="text" value="<?php echo isset($view['title'])?$view['title']:''?>" id="title" name="title"  class="required"> 
                            </td>
                        </tr>
 
                         <tr>
                            <td  colspan="2" style='text-align:right'>
                                <button type="button"  onclick="add_level()">添加选项</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" >
                                  <table width="100%" cellspacing="0" class='sub_table'>
                                        <thead >
                                                <tr>
                                                  <th>选项名称</th>
                                                  <th width='50px'>操作</th>
                                                </tr>
                                        </thead>
                                        <tbody id='level'>
                                            <?php  if(isset($view['element']) && $view['element']){ ?>
                                            <?php foreach($view['element'] as $k=>$p){ ?>
                                                <tr>
                                                <td><input  disabled="disabled" style='width:220px' type="text" value='<?php echo $p['name'] ?>'  placeholder='' name='element[<?php echo $k; ?>]'></td>
                                                <td>
                                                    <!--<a href='javascript:void(0)' onclick="del_level(this);">删除</a>-->
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <?php }else{ ?>
                                            <tr>
                                                <td><input style='width:220px' type="text" value=''  placeholder='' name='element[1]'></td>
                                                <td>
                                                    <!--<a href='javascript:void(0)' onclick="del_level(this);">删除</a>-->
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                 </table>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="border:none" class='table_foot' colspan="2" ><input type="submit" class="btn btn-danger" value="提交"></td>
                        </tr>
                        </tbody>
                        </table>        
                        </form>
                </div>



        </div> 
<script>
 function add_level(){
           var $i = $('#level').find('tr').length;
           var  $html ="<tr>";
                $html +="<td><input style='width:220px'  type='text' value='' placeholder='' name='element["+(parseInt($i)+1)+"]'  ></td>";
                $html +="<td><a href='javascript:void(0)' onclick='del_level(this);'>删除</a></td>";
                $html +="</tr>";
                $($html).appendTo($('#level'));
//                var $num = $('#lx_'+type).find('tr').length;
//                $('#lx_'+type).find('.lx_title').attr('rowspan',$num);
        }
function del_level(obj){
    $(obj).parent().parent().remove();
}
</script>

