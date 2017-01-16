       <div class='bgf clearfix'>
               
                <div class="center_top clearfix">
                <ul>
                <li><a   class="btn btn-primary" href="javascript:history.go(-1);">返回</a></span>  
                </ul>
                </div>

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('management/add/');?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($result['id'])?$result['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                       <tr>
                            <td width='120' align="right">行为操作:</td>
                            <td>
                                <input  type="text" name="name" id="name"  class="required"  value="<?php echo isset($result['name'])?$result['name']:'';?>" ><div style="float:left;" id="name_msg"></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' align="right">所属应用:</td>
                            <td>
                                <select id="" name="pid" style="width:155px">
                                <?php 
                                    $pid = $result['pid'];
                                    foreach($res as $val){
                                ?>
                                    <option value="<?php echo $val['id']?>" <?php echo $pid==$val['id'] ? 'selected' : '';?>><?php echo $val['name']?></option>
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                      <tr>
                            <td width='120' align="right">积分标识:</td>
                            <td>
                                <input  type="text" name="mark" id="mark"  class="required"  value="<?php echo isset($result['mark'])?$result['mark']:'';?>" >（拼音标识）<div style="float:left;" id="name_msg"></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' align="right">积分分数:</td>
                            <td><input  type="text" name="point"   class="required" id="pwd"  value="<?php echo isset($result['point'])?$result['point']:'';?>" style="float:left"><div style="float:left" id="pwd_msg"></div></td>
                        </tr>
                        <tr>
                            <td width='120' align="right">获得规则:</td>
                            <td><input  type="text" name="rule"   class="required"  value="<?php echo isset($result['rule'])?$result['rule']:'';?>" style="float:left"><div style="float:left" id="rule_msg"></div></td>
                        </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
