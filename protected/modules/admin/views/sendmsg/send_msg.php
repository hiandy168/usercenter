     <div class='bgf clearfix'>
               
        <div class="center_top clearfix">
        <ul>
          <li><span><a class="btn btn-primary" href="javascript:;">添加/编辑用户</a></span></li>
        </ul>
        </div>
        <div class="form_list">
               <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/member/')?>" method="post">
                <table cellSpacing=0 width="100%" class="content_view">                        
                <tr>
                    <td width='120' align="right">标题:</td>
                    <td>
                        <input  type="text" name="name" id="name"  class=""  value="">
                    </td>
                </tr>
                <tr>
                    <td width='120' align="right">消息内容:</td>
                    <td>
                        <textarea name='content' style="margin: 0px; height: 119px; width: 413px;"></textarea>
                    </td>
                </tr>
                 <tr>
                    <td width='120' align='right' style="border:none"></td>
                    <td  style="border:none"><input type="submit" value='发送消息' class="btn btn-success"></td>
                </tr>
                </table>        
              </form>
        </div>
    </div>


