
   
    <div class='bgf clearfix'>
             
              
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('message/'.$fun);?>" method="post" onsubmit="return checkfrom();">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
    
                        <tr>
                            <td width='120' class="t">标题</td>
                            <td>
                               <?php echo isset($view['title'])?$view['title']:'';?>
                            </td>
                        </tr>
                          <tr>
                            <td width='120' class="t">内容</td>
                            <td>
                               <?php echo isset($view['content'])?$view['content']:'';?>
                            </td>
                        </tr>
                          <tr>
                            <td width='120' class="t">发送时间</td>
                            <td>
                               <?php echo isset($view['createtime'])?date('Y-m-d H:i:s',$view['createtime']):'';?>
                            </td>
                        </tr>
                
                        
                    
                        <tr>
                            <td width='120' class="t">回复<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <textarea name='result'style='width:500px;height:200px;'><?php echo isset($view['result'])?$view['result']:'';?></textarea>
                            </td>
                        </tr>
                      
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-danger"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
     




