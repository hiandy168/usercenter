       <div class='bgf clearfix'>
               
                <div class="center_top clearfix">
                <ul>
                <li><a   class="btn btn-primary" href="javascript:history.go(-1);">返回</a></span>  </li>
                </ul>
                </div>

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('management/add/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($id)?$id:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                       <tr>
                            <td width='120' align="right">积分描述:</td>
                            <td>
                                <input  type="text" name="name" id="name"  class="required"  value="<?php echo isset($name)?$name:'';?>" ><div style="float:left;" id="name_msg"></div>
                            </td>
                        </tr>
                      <tr>
                            <td width='120' align="right">积分标识:</td>
                            <td>
                                <input  type="text" name="mark" id="mark"  class="required"  value="<?php echo isset($mark)?$mark:'';?>" >（字母标识）<div style="float:left;" id="name_msg"></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' align="right">积分分数:</td>
                            <td><input  type="text" name="score"   class="required" id="pwd"  value="<?php echo isset($score)?$score:'';?>" style="float:left"><div style="float:left" id="pwd_msg"></div></td>
                        </tr>
                        <tr>
                            <td width='120' align="right">获得规则:</td>
                            <td><input  type="text" name="rule"   class="required"  value="<?php echo isset($rule)?$rule:'';?>" style="float:left"><div style="float:left" id="rule_msg"></div></td>
                        </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
