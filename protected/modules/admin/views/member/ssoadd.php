       <div class='bgf clearfix'>
               
                <div class="center_top clearfix">
                <ul>
                <li><span><a class="btn btn-primary" href="javascript:;">添加/编辑</a></span></li>
                </ul>
                </div>
    

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/member/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($data->id)?$data->id:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  

                          <tr>
                            <td width='120' align="right">接入名称:</td>
                            <td>
                                <input  type="text" name="name" id="name"  class="required"  value="<?php echo isset($data->name)?$data->name:'';?>"  >
                                <div id="name_msg"></div>
                            </td>
                        </tr>

                            <tr>
                                <td width='120' align="right">描述:</td>
                                <td>
                                    <input  type="text" name="description" id="name"  class="required"  value="<?php echo isset($data->description)?$data->description:'';?>"  >
                                    <div id="name_msg"></div>
                                </td>
                            </tr>

                            <tr>
                                <td width='120' align="right">appid:</td>
                                <td>
                                    <input  type="text" name="agentid" id="name"  class="required"  value="<?php echo isset($data->agentid)?$data->agentid:'';?>"  >
                                    <div id="name_msg"></div>
                                </td>
                            </tr>

                            <tr>
                                <td width='120' align="right">secret:</td>
                                <td>
                                    <input  type="text" name="secret" id="name"  class="required"  value="<?php echo isset($data->secret)?$data->secret:'';?>"  >
                                    <div id="name_msg"></div>
                                </td>
                            </tr>
                            <tr>
                                <td width='120' align="right">回调地址:</td>
                                <td>
                                    <input  type="text" name="url" id="name"  class="required"  value="<?php echo isset($data->url)?$data->url:'';?>"  >
                                    <div id="name_msg"></div>
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
