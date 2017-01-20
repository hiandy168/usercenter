<?php echo $this->renderpartial('/common/header_new',$config); ?>

<?php echo $this->renderpartial('/common/assembly',array('active'=>$config['active'],'pid'=>$config['pid']))?>
<script src="<?php echo $this->_theme_url;?>assets/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/css/vote.css">

    <!-- <div class="ad-act-list w1000 bxbg mgt30 clearfix" xmlns="http://www.w3.org/1999/html">
        <div class="ad-app-list-tit clearfix"> -->

          <div class="ad-act-list  bxbg " xmlns="http://www.w3.org/1999/html">
      <!--   <div class="ad-app-list-tit">
            <div class="fl tl">
                <h3>编辑活动</h3>
            </div>
            <div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>
        </div> -->
        <!--tit end-->
        <div class="ad-edit-app">
        <!-- <div class="ad-edit-app-nav clearfix"> -->
        
            <div class="ad-edit-app-nav ">
                <ul>
                    <li class="selected">
                        <a href="">编辑活动</a>
                    </li>
                  <!--  <li class="">
                        <a href="">实时预览</a>
                    </li>-->
                    <?php if(!empty($fid)){?>
                        <li class="">
                            <a href="">字段设置</a>
                        </li>
                    <?php } else{?>
                        <li class="" onclick="set()">
                            <a href="">字段设置</a>
                        </li>
                    <?php } ?>
                    <li class="">
                        <a href="">接口示例</a>
                    </li>
                    <li class="">
                        <a href="">调用示例</a>
                    </li>

                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">
                <div class="ad-edit-app-1 ad-edit-app-condiv  clearfix" style="display: block;">
                    <div class="ad-edit-app-1formbg fl">
                        <form id="img_form" method="POST" enctype="multipart/form-data" >
                        <img id="imgPreview" src="<?php echo JkCms::show_img($activity_info['share_img']); ?>" />
                        <i>上传图像
                              <input class="fileinput" type="file" onchange="uploadImg(this)"  name="imgFile" id="upimg" value="" /></i>
                            </form>
                        <p>该图像是用于微信分享时使用建议上传大小为300*300</p>
                        <input type="hidden" name="share_img" id="share_img" value="<?php echo $activity_info['share_img']?>">

                    </div>
                    <!--left bg end-->
                    <div class="ad-edit-app-1form">

                        <div class="ad-act-formmain">
                            <h2 class="h2-tit">请您耐心填写完表单，活动的效果会更好！</h2>
                            <input type="hidden" value="<?php echo $config['pid']?>" name="pid">
                            <?php
                            if(isset($activity_info['id'])){
                                ?>
                                <input type="hidden" value="<?php echo $activity_info['id']?>" name="id">
                                <?php
                            }
                            ?>
                            <div class="form-content">
                                <div class="t_title">活动名称<span>（1-20个字符）</span></div>

                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>" placeholder="请填写活动名称" class="form-control " name="title" /></span>
                                </div>

                                <div class="t_title">类型<span></span></div>
                                <div class="form-inp">
                                    <select name="component" <?php if(!empty($fid)){ ?>disabled="disabled<?php }?>" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;" id="component" class="display_type">
                                        <option value="0" <?php if($activity_info['component']==0){ ?>selected ="selected "<?php } ?>>报名</option>
                                        <option value="1" <?php if($activity_info['component']==1){ ?>selected ="selected "<?php } ?>>投票</option>
                                    </select>
                                </div>
                                <?php if($activity_info['component']==0){ ?>
                                    <div class="add_bm_inp" style="display: block">
                                        <div class="t_title">活动地点<span>（1-20个字符）</span></div>
                                        <div class="form-inp">
                                          <span>
                                            <input type="text" value="<?php echo isset($activity_info['address']) ? $activity_info['address'] : ''; ?>" placeholder="请填写活动地点" class="form-control " name="address" /></span>
                                        </div>
                                        <div class="t_title">联系方式<span>（1-20个字符）</span></div>
                                        <div class="form-inp">
                                          <span>
                                            <input type="text" value="<?php echo isset($activity_info['phone']) ? $activity_info['phone'] : ''; ?>" placeholder="请填写联系方式" class="form-control " name="phone" /></span>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($activity_info['component']==1){ ?>


                                <div class="add_bm_inp_fs" style="display: block">
                                    <div class="t_title">持有票数(票数最大是三位数 999)<span></span></div>
                                    <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo $activity_info['hold_vote']?>" placeholder="请填写活动期间用户持有票数" class="form-control" name="hold_votes" id="hold_votes" maxlength=3 /></span>
                                    </div>

                                        <div class="t_title">投票方式<span></span></div>
                                        <div class="form-inp">
                                              <select name="rule" id="rule" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                                  <option value="1" <?php if($activity_info['rule']==1){ ?>selected ="selected "<?php } ?>>活动期间只能投<?php echo $activity_info['hold_vote']?>票</option>
                                                  <option value="2" <?php if($activity_info['rule']==2){ ?>selected ="selected "<?php } ?>>每天可投<?php echo $activity_info['hold_vote']?>票</option>
                                              </select>
                                          </div>


                                    <div class="t_title">是否参与抽奖<span></span></div>
                                    <div class="form-inp">
                                        <select name="lucky" id="lucky" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                            <option value="1">是</option>
                                            <option value="0">否</option>
                                        </select>
                                    </div>

                                        <div class="t_title">抽奖组件<span></span></div>
                                        <div class="form-inp">
                                            <select name="activity" id="activity" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                                <option value="1">刮刮卡</option>
                                                <option value="2">大转盘</option>
                                            </select>
                                        </div>

                                    <div class="t_title">抽奖活动列表<span></span></div>
                                    <div class="form-inp">
                                        <select name="activity" id="activity" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                            <option value="0">请选择</option>
                                        </select>
                                    </div>


                                </div>
                                <div class="add_bm_inp_fs" style="display: block">
                                    <div class="t_title">自主报名<span></span></div>
                                    <div class="form-inp">
                                        <select name="isshow" id="isshow" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                            <option value="1" <?php if($activity_info['isshow']==1){ ?>selected ="selected "<?php } ?>>开启报名</option>
                                            <option value="2" <?php if($activity_info['isshow']==2){ ?>selected ="selected "<?php } ?>>关闭报名</option>
                                        </select>
                                    </div>
                                </div>
                                <?php }else{ ?>

                                    <div class="add_bm_inp_fs" style="display: none">
                                        <div class="t_title">持有票数<span></span></div>
                                        <div class="form-inp">
                                      <span>
                                        <input type="text" value="" placeholder="请填写活动期间用户持有票数" class="form-control" name="hold_votes" id="hold_votes" maxlength="3"/></span>
                                        </div>
                                    </div>

                                    <div class="add_bm_inp_fs" style="display: none">
                                        <div class="t_title">是否参与抽奖<span></span></div>
                                        <div class="form-inp">
                                            <select name="lucky" id="lucky" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                                <option value="1">是</option>
                                                <option value="0">否</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="add_bm_inp_fs" style="display: none">
                                        <div class="t_title">抽奖组件<span></span></div>
                                        <div class="form-inp">
                                            <select name="activity" id="activity" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                                <option value="1">刮刮卡</option>
                                                <option value="2">大转盘</option>
                                            </select>
                                        </div>
                                    </div>

                                <div class="add_bm_inp_fs" style="display: none">
                                    <div class="t_title">投票方式<span></span></div>
                                    <div class="form-inp">
                                        <select name="rule" id="rule" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                            <option value="0">请选择</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="add_bm_inp_fs" style="display: none">
                                    <div class="t_title">自主报名<span></span></div>
                                    <div class="form-inp">
                                        <select name="isshow" id="isshow" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                            <option value="1">开启报名</option>
                                            <option value="2">关闭报名</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="t_title">活动开始时间<span>使用自定义字段，请选择未开始日期</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['start_time']) ? date('Y-m-d H:i:s', $activity_info['start_time']) : ''; ?>" placeholder="请填写活动开始时间" class="form-control" name="start_time" id="start" /></span>

                                </div>
                                <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['end_time']) ? date('Y-m-d H:i:s', $activity_info['end_time']) : ''; ?>" placeholder="请填写活动结束时间" class="form-control" name="end_time" id="end" />
                                      </span>
                                </div>

                                <div class="t_title"><i style="color: red">*</i>活动介绍</div>
                                <div class="form-inp">
                                      <span>
                                     <textarea style="resize-y:none;width:100%;height:150px;border:1px solid #CDCDCD;" value="" name='desc' rows="3" cols="20" placeholder="活动介绍" class="input_text"><?php echo isset($activity_info['desc']) ? $activity_info['desc'] : ''; ?></textarea>                                     </span>
                                </div>

                                <div class="t_title"><i style="color: red">*</i>活动背景</div>
                                <div class="form-inp">
                                      <span>
                                    <textarea style="resize-y:none;width:100%;height:150px;border:1px solid #CDCDCD;" value="" name='background' rows="3" cols="20" placeholder="活动背景" class="input_text"><?php echo isset($activity_info['background']) ? $activity_info['background'] : ''; ?></textarea>
                                    </span>
                                </div>

                                <!-- 上传图片1 start -->
                                <div class="t_title"><i style="color: red">*</i>投票专题图片(图片大小：640*280)</div>
                                <div class="form-inp">
                                   <!-- <form id="img_vote" method="POST" enctype="multipart/form-data" >
                                        <img id="imgPreview_vote" src="<?php /*if($activity_info['img']) {echo JkCms::show_img($activity_info['img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} */?> "/>
                                        <input class="fileinput" type="file" onchange="uploadImg_vote(this)"  name="imgFile" id="upimg" value="" />
                                    </form>
                                    <input type="hidden" name="img" id="img" value="<?php /*echo $activity_info['img']*/?>">-->


                                    <form id="img_scratch" method="POST" enctype="multipart/form-data" >
                                        <img id="imgPreview_vote" onclick="upload()" src="<?php if($activity_info['img']) {echo JkCms::show_img($activity_info['img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                                        <input class="fileinput" style="display: none" type="file" onchange="uploadImg(this,'img','imgPreview_vote','img_scratch')"  name="imgFile" id="upimg1" value="" />
                                    </form>
                                    <input type="hidden" name="img" id="img" value="<?php echo $activity_info['img']?>">

                                </div>
                                <div class="t_title">分享描述</div>
                                <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['share_desc']) ? $activity_info['share_desc'] : ''; ?>" name='share_desc' placeholder="分享描述" class="form-control" />
                                  </span>
                                </div>
                                <div class="t_title">+添加标签</div>
                                <?php if(!$tag[0]['id']==null){?>
                                    <div class="add-tags">
                                        <?php foreach($tag as $tags){?>
                                            <label for="<?php echo $tags['id'] ?>">
                                                <input type="checkbox"  <?php if(in_array($tags['id'],$ptag)){ ?>checked ="checked "<?php } ?> id="<?php echo $tags['id'] ?>" name="tag" value="<?php echo $tags['id'] ?>">
                                                <i><?php echo $tags['name'] ?></i>
                                            </label>
                                        <?php }?>
                                    </div>
                                <?php }?>
                                <button class="save_button adbtn linear" style="width: 30%;margin: 30px 0px;">保存</button>
                            </div>
                        </div>
                    </div>
                </div>

                <style type="text/css" media="screen">
                                   .tc2 input {    height: 18px;padding: 8px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;}
                                </style>


                <div class="ad-example-app-1 ad-edit-app-condiv clearfix">
                    <?php if(!empty($fid)){?>
                <div class="table ad-zd-table">
                    <table id="tab2">
                        <tbody>
                        <tr class="thead">
                            <td colspan="6" class="tc">自定义字段(最多30项，自定义字段不能检索)</td>
                        </tr>
                        <tr class="thead">
                            <td class="tc2">排序</td>
                            <td class="tc1">中文标题</td>
                            <td class="tc2">表现形式</td>
                            <td >展示</td>
                            <td >必填</td>
                           <!-- <td width="200px">最大字符</td>-->
                            <?php if($activity_info['start_time']>time()&&time()<$activity_info['end_time']){?>
                            <td >操作</td>
                            <?php }  ?>
                        </tr>
                        <?php foreach($formslist as $forms){?>
                        <tr class="param" rowkey="<?php echo $forms['id'] ?>">
                            <td class="tc2">
                                <input rowkey="<?php echo $forms['id'] ?>" name="name_rank" id="name_rank" class="w150" size="11" type="text" value="<?php echo $forms['list'] ?>">
                            </td>
                                
                            <td class="tc1">
                                <input rowkey="<?php echo $forms['id'] ?>" type="hidden" name="custom_field_name" id="custom_field_name" value="<?php echo $forms['id'] ?>">
                               <input rowkey="<?php echo $forms['id'] ?>" name="name_list" id="name_list" class="w150" size="11" type="text" value="<?php echo $forms['title'] ?>">
                            </td>

                                <td class="tc2">
                                <input type="hidden" value="<?php echo $forms['forms'] ?>" id="display_type_text_list_<?php echo $forms['id'] ?>">
                            <?php if($activity_info['start_time']>time()&&time()<$activity_info['end_time']){ ?>
                                <select class="sel_data_type"  rowkey="<?php echo $forms['id'] ?>" name="display_type_text_list" id="display_type_text_list">
                            <?php }else{ ?>
                                    <select class="sel_data_type" disabled ="disabled" rowkey="<?php echo $forms['id'] ?>" name="display_type_text_list" id="display_type_text_list">
                            <?php } ?>
                                        <option value="0" <?php if($forms['forms']==0){ ?>selected ="selected "<?php } ?>>单行文本</option>
                                        <option value="1" <?php if($forms['forms']==1){ ?>selected ="selected "<?php } ?>>多行文本</option>
                                        <option value="2" <?php if($forms['forms']==2){ ?>selected ="selected "<?php } ?>>单选类型</option>
                                        <option value="3" <?php if($forms['forms']==3){ ?>selected ="selected "<?php } ?>>多选类型</option>
                                </select>
                                    <?php if($activity_info['start_time']>time()&&time()<$activity_info['end_time']){?>
                                    <?php if($forms['forms']==2 || $forms['forms']==3){?>
                                        <span  class="pointer item_tips">编辑</span>
                                    <?php }else{ ?>
                                        <span  class="pointer item_tips" style="display: none;">编辑</span>
                                    <?php } ?>
                                    <?php } ?>
                                    <input rowkey="<?php echo $forms['forms'] ?>" type="hidden" name="type" id="<?php echo $forms['forms'] ?>" value="<?php echo $forms['question'] ?>">
                                    <input rowkey="<?php echo $forms['id'] ?>" type="hidden" name="qid" id="" value="<?php echo $forms['qid'] ?>">
                                </td>
                            <td>
                                <input rowkey="<?php echo $forms['id'] ?>" <?php if($forms['shows']==1){ ?>checked ="checked "<?php } ?> type="checkbox" id="result_display_field_list" name="result_display_field_list" value="<?php echo $forms['shows']?>">
                            </td>
                            <td>
                                <input rowkey="<?php echo $forms['id'] ?>" <?php if($forms['requires']==1){ ?>checked ="checked "<?php } ?> type="checkbox" id="result_display_field_lists" name="result_display_field_lists"  value="<?php echo $forms['requires']?>">
                            </td>
                            <?php if($activity_info['start_time']>time()&&time()<$activity_info['end_time']){?>
                            <td>
                                <a onclick="del(this,<?php echo $forms['id'] ?>)" class="delete" activity_id="activityid" field_id="" title="删除">删除</a>
                            </td>
                            <?php }else{  ?>
                                <td>
                                    <a onclick="actioning()" class="delete" activity_id="activityid" field_id="" title="删除">删除</a>
                                </td>
                            <?php }?>
                        </tr>
                        <?php } ?>
                        </tbody></table>
                    <?php if($activity_info['start_time']>time()&&time()<$activity_info['end_time']){?>
                    <div class="tb_end"><input type="button" value="添加自定义字段" id="self_add" class="button2"> <input type="button" value="更新自定义字段" id="self_save" class="button_highlight"></div>
                    <?php }else{?>
                        <div class="tb_end"><input type="button" value="添加自定义字段" onclick="actioning()" class="button2"> <input type="button" value="更新自定义字段" onclick="actioning()" class="button_highlight"></div>
                    <?php } ?>
                    <!--<form method="POST" action="<?php /*echo $this->createUrl('/activity/vote/admin',array('vid'=>$vid))*/?>" enctype="multipart/form-data" >-->
                    <div id="field_add_form" style="display: none;">
                        <div class="form">
                                  
                             <div class="field">
                                <div class="f_label">排序:<span class="t_error "></span></div>
                                <div class="f_input"><input class="name w150" id="textname" name="textrank" type="text"></div>
                            </div>

                            <div class="field">
                                <div class="f_label">标题:<span class="t_error "></span></div>
                                <div class="f_input"><input class="name w150" id="textname" name="name" type="text"></div>
                            </div>
                            <div class="field">
                                <div class="f_label">表现形式:<span class="t_error "></span></div>
                                <div class="f_input">
                                    <select name="display_type_text_list" id="textkindselect" class="display_type">
                                        <option value="0">单行文本</option>
                                        <option value="1">多行文本</option>
                                        <option value="2">单选类型</option>
                                        <option value="3">多选类型</option>
                                    </select> <span style="display: none;" id="pop_edit_text_kind" class="">编辑</span>
                                    <input type="hidden" name="pop_edit_text_kind_val" id="pop_edit_text_kind_val" value="" />
                                    <!-- <input type="hidden" class="select_items" name="display_type_str" />
                                    <input type="hidden" class="multi_max" name="custom_multi_max" /> -->
<!--                                    <input  type="hidden" name="addtype" id="addtype" value="">-->
                                </div>
                            </div>
                            <div class="field">
                                <div class="f_label">是否展示:</div>
                                <div class="f_input">
                                    <label>
                                        <input name="result_display_field" class="result_display_no" checked="checked" type="radio" value="0"> 不展示
                                    </label>
                                    <label style="margin-left: 10px;">
                                        <input name="result_display_field" class="result_display_yes" type="radio" value="1"> 展示
                                    </label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="f_label">是否必填:</div>
                                <div class="f_input">
                                    <label>
                                        <input name="require" class="require_no" checked="checked" type="radio" value="0">否
                                    </label>
                                    <label style="margin-left: 10px;">
                                        <input name="require" class="require_yes" type="radio" value="1"> 是
                                    </label>
                                </div>
                            </div>
                            <div class="form_bt">
                                <input type="button" value="确定" class="button_highlight ok" id="add_input" />
                                <input type="button" value="关闭" class="button_highlight cancelMsg" onclick="$('#field_add_form').hide()" />
                            </div>
                           <!-- </form>-->
                        </div>
                    </div>

                </div>
                    <?php } ?>
                </div>



                <div class="ad-example-app-1 ad-edit-app-condiv clearfix">


                    <div class="ad-example-app-2">
                        <ul>
                            <li><span>开发者示例：</span>
                                <em>&nbsp;</em>
                                <i></i>
                                </li>
                            <li>
                                <pre name="code" class="c-sharp">
                                include 'Dachuw.php';
                                $dachu=new Dachu('aapid','appsercert');
                                //项目的用户的唯一标识符;
                                $openid= '***';
                                //$redirect = $dachu->getMemberUrl();//获取会员中心URL
                                $redirect   =   '<?php echo $this->_siteUrl?>/activity/vote/view/id/<?php echo $_GET['fid'] ?>';
                                //获取自动登录URL
                                $url        = $dachu->buildAutoLoginRequest($openid,$redirect);
                                //跳转
                                $dachu->redirect($url);
                                </pre>
                            </li>
                        </ul>
                        <a href="/dachu/activity_sdk.zip" class="demo-down linear adbtn">DEMO下载</a>
                    </div>
                </div>



                <div class="ad-example-app-1 ad-edit-app-condiv clearfix">


                    <div class="ad-example-app-2">
                        <ul>
                            <li><span>调用示例：</span>
                                <em>&nbsp;</em>
                                <i></i>
                            </li>
                            <li>
                                <pre name="code" class="c-sharp">
                                1.最新报名数据
                                    链接:<?php echo $this->_siteUrl?>/activity/vote/views/id/<?php echo $_GET['fid'] ?>/page/0/pid/<?php echo $_GET['pid'] ?>;
                                2.排行榜数据
                                    链接:<?php echo $this->_siteUrl?>/activity/vote/rankings/id/<?php echo $_GET['fid'] ?>/page/0/pid/<?php echo $_GET['pid'] ?>;
                                3.二维码链接
                                    链接:<?php echo $this->_siteUrl?>/activity/vote/details/id/305/vid/<?php echo $_GET['fid'] ?>;
                                </pre>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="coverDiv"></div>

    <div class="form-add-zd">
        <h3></h3>
        <ul>
            <li><label>字段标题</label><span><input type="text" name="" id="" value="" /></span><em onclick="$(this).parent().remove()">删除</em></li>
            <li><label>字段标题</label><span><input type="text" name="" id="" value="" /></span><em onclick="$(this).parent().remove()">删除</em></li>
            <li><label>字段标题</label><span><input type="text" name="" id="" value="" /></span><em onclick="$(this).parent().remove()">删除</em></li>
        </ul>
        <div class="form_bt">
            <input type="button" value="增加"
                   class="button_highlight ok" id="add_zd_check" />
            <input type="button" value="确定" id="conf-btn"
                   class="button_highlight ok" onclick="hideMask(this)" />
            <input type="button" value="关闭"
                   class="button_highlight cancelMsg" onclick="hideMasks(this)" />
        </div>
    </div>

    <script>

        $("#hold_votes").change(function(){
            var num= $(this).val();
            if(num){
                $("#rule").html( '<option value="1">活动期间只能投'+num+'票</option> <option value="2">每天可投'+num+'票</option>');

            }
        })
    </script>




    <script type="text/javascript" charset="utf-8">

        function set(){
            layer.msg('请先保存后再次编辑，修改字段设置', {icon: 2,time:2000},function(){
            });
        }

        function actioning(){
            layer.msg('活动已 开始or结束 无法修改', {icon: 2,time:2000},function(){
            });
        }
        function upload() {
            document.getElementById("upimg1").click();
        }
        function del(obj,id){
            layer.confirm('确认要删除吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url:"<?php echo $this->createUrl('delForms');?>",
                    type: "POST",
                    data:{id:id},
                    dataType:"json",
                    success:function(data){
                        if(data['statue']==1){
                            layer.msg('删除成功！', {icon: 1,time:2000},function(){
                                $(obj).parent().parent().remove();
                            });
                        }
                        else{
                            layer.msg('删除失败', {icon: 2,time:2000},function(){
                            });
                        }
                    }
                });
            });
            return;
        }
        $(function(){
            $("html").on("change","select[name='display_type_text_list']",function(){
                var hideVal=$(this).find("option:selected").val();
                $(this).prev().val(hideVal);
            });
            $("html").on("click","input[name='result_display_field_list'],input[name='result_display_field_lists']",function(){
                if($(this).is(':checked')){
                   $(this).val(1);
                }else{
                    $(this).val(0);
                }
            })
            $('#self_add').click(function () {
                $("#field_add_form").show();
            })
            $("#self_save").on("click",function(){
                $("#self_save").attr("disabled", true);
                var len=$(".param").length;
                var arr=[];
                var result = [];
                for (var i=0;i<len;i++) {
                    $(".param").eq(i).find("input").each(function(){
                        var value = $(this).val();
                        arr.push(value);
                    });
                }
                for(var i=0,len=arr.length;i<len;i+=8){
                    result.push(arr.slice(i,i+8));
                }
                console.log(result);
                $.ajax({
                    url:"<?php echo $this->createUrl('editForms');?>",
                    type: "POST",
                    data:{result:result},
                    dataType:"json",
                    success:function(data){
                        setTimeout(function(){
                            $("#self_save").attr("disabled", false);
                        },3000)
                        if(data['statue']==1){
                            layer.msg('修改成功！', {icon: 1,time:2000},function(){
                            });
                        }
                        else{
                            layer.msg('修改失败', {icon: 1,time:2000},function(){
                            });
                        }
                    }
                });
            })
            $("#add_input").click(function(){
                if($("input[name='textrank']").val()==""){
                 layer.msg('请填写字段标题', {icon: 2,time:2000},function(){
                            });
                 return false;
            }else if($("input[name='name']").val()==""){
                 layer.msg('请填写字段标题', {icon: 2,time:2000},function(){
                            });
                 return false;
            }else{
                var id     = $("input[name='id']").val();
                var list     = $("input[name='textrank']").val();
                var title     = $("input[name='name']").val();
                var shows=$('input[name="result_display_field"]:checked').val();
                var requires   = $('input[name="require"]:checked').val();
                var forms=$("#textkindselect").find('option:selected').val();
                var type     = $("input[name='pop_edit_text_kind_val']").val();
                var qid     = $("input[name='qid']").val();
                $("#add_input").attr("disabled", true);
                $.ajax({
                    url:"<?php echo $this->createUrl('addForms');?>",
                    type: "POST",
                    data:{id:id,list:list,title:title,forms:forms,requires:requires,shows:shows,type:type,qid:qid},
                    dataType:"json",
                    success:function(data){
                        if(data['statue']==1){
                            setTimeout(function(){
                                $("#add_input").attr("disabled", false);
                            },3000)

                            layer.msg('添加成功！', {icon: 1,time:2000},function(){
                                //var rowkey=(Math.random().toFixed(6))*1000000;
                                var rowkey=id;
                                var str = '';
                                str += '<tr class="param" rowkey="'+data['formid']+'">';

                                str += '<td class="tc2">';

                                str += '<input rowkey="'+data['formid']+'" name="name_rank" id="name_rank" class="w150" size="11" type="text" value="'+list+'">';
                                str += '</td>';

                                str += '<td class="tc1">';
                                str += '<input rowkey="'+data['formid']+'" type="hidden" name="custom_field_name" id="custom_field_name" value="'+data['formid']+'"/>';
                                str += '<input rowkey="'+data['formid']+'" name="name_list" id="name_list" class="w150" size="11" type="text" value="'+title+'">';
                                str += '</td>';
                                str += '<td class="tc2">';
                                str += '<input type="hidden" value="'+forms+'" id="display_type_text_list_'+data['formid']+'">';
                                str += '<select class="sel_data_type" rowkey="'+rowkey+'" name="display_type_text_list" id="display_type_text_list">';
                                if(forms==0){
                                    str += '<option '+''+ ' value="0" selected="selected">单行文本</option>';
                                }else{
                                    str += '<option '+''+ ' value="0" >单行文本</option>';
                                }
                                if(forms==1){
                                    str += '<option '+''+ ' value="1" selected="selected" >多行文本</option>';
                                }else{
                                    str += '<option '+''+ ' value="1" >多行文本</option>';
                                }
                                if(forms==2){
                                    str += '<option '+''+ ' value="2" selected="selected">单选类型</option>';
                                }else{
                                    str += '<option '+''+ ' value="2">单选类型</option>';
                                }
                                if(forms==3){
                                    str += '<option '+''+ ' value="3" selected="selected" >多选类型</option>';
                                }else{
                                    str += '<option '+''+ ' value="3" >多选类型</option>';
                                }
                                str += '</select>';
                                if(forms==2||forms==3){
                                    str +='<span style="display: block;"  class="pointer item_tips">编辑</span>';
                                }else if(forms==0||forms==1){
                                    str +='<span style="display: none;" class="pointer item_tips">编辑</span>';
                                }
                                str += ' <input rowkey="'+data['formid']+'" type="hidden" name="type" id="" value="'+type+'">';
                                str += ' <input rowkey="'+data['qid']+'" type="hidden" name="qid" id="" value="">';
                                str += '</select>';

                                str += '</td>';
                                str += '<td>';
                                if(shows==0){
                                    str += '<input rowkey="'+rowkey+'" type="checkbox" value="0" id="result_display_field_list" name="result_display_field_list" ' +''+ '>';
                                }else{
                                    str += '<input rowkey="'+rowkey+'" type="checkbox" value="1" checked ="checked"  id="result_display_field_list" name="result_display_field_list" ' +''+ '>';
                                }
                                str += '</td>';
                                str += '<td>';

                                if(requires==0){
                                    str += '<input rowkey="'+rowkey+'" type="checkbox" value="0" id="result_display_field_lists" name="result_display_field_lists" ' +''+ '>';
                                }else{
                                    str += '<input rowkey="'+rowkey+'" type="checkbox" value="1" checked ="checked" id="result_display_field_lists" name="result_display_field_lists" ' +''+ '>';
                                }
                                str += '</td>';
                                /* str += '<td>';
                                 str += '<input rowkey="'+''+ ' >';
                                 str += '</td>';
                                 str += '<td>';
                                 str += '<input rowkey="'+rowkey+'" id="max_list'+rowkey+'" name="max_list'+rowkey+'" id="max_list'+rowkey+'" size="11" type="text" value="'+''+'" class="w50">';
                                 str += '</td>';*/
                                str += '<td>';
                                str += '<a onclick="del(this,'+data['formid']+')" class="delete" activity_id="activityid" field_id="" title="删除" >删除</a>';
                                str += '</td>';
                                str += '</tr>';
                                $('#tab2').append($(str));
                                $('#field_add_form').hide();
                                $("input[name='name']").val("");
                                $("input[name='textrank']").val("");
                                $("#textkindselect").val("0").next().hide().next().val("");
                            });
                        }
                        else{
                            layer.msg('添加失败', {icon: 2,time:2000},function(){
                            });
                        }
                    }
                });
            }
            })

            $("html").on("change","select[name='display_type_text_list']",function(){
                var el=$(this);
                var attrs=el.parent().parent().attr("rowkey");
                $("#conf-btn").attr("rowkey",attrs);
                $(this).next().next().addClass(attrs);
                // if (typeof attrs !== typeof undefined) {
                //     var rowkey=el.parent().parent().attr("rowkey");
                //     $.ajax({
                //         url:"<?php echo $this->createUrl('type');?>",
                //         type: "POST",
                //         data:{rowkey:rowkey},
                //         dataType:"json",
                //         success:function(data){
                //             if(data['statue']==1){
                //                 layer.msg('修改成功！', {icon: 1,time:2000},function(){
                //                 });
                //             }
                //             else{
                //                 layer.msg('修改失败', {icon: 1,time:2000},function(){
                //                 });
                //             }
                //         }
                //     });
                // }
                if(el.val()=="2"){
                    $(".form-add-zd h3").html("单选类型");
                    $(this).next().show();
                    $(".coverDiv").show();
                    $(".form-add-zd").show();
                    if( $(this).next().next().val()!=""){
                        var kind_val=$(this).next().next().val().replace(/_/g,',').split(",");
                        $(".form-add-zd ul").html("");
                        for (var i=0; i<kind_val.length;i++) {
                            var str= '<li>'
                                +'<label>字段标题</label>'
                                +'<span><input type="text" name="" id="" value="'+kind_val[i]+'" /></span>'
                                +'<em onclick="$(this).parent().remove()">删除</em>'
                                +'</li>'
                            $(".form-add-zd ul").append(str);
                        }
                    }
                }else if(el.val()=="3"){
                    $(".form-add-zd h3").html("多选类型");
                    $(this).next().show();
                    $(".coverDiv").show();
                    $(".form-add-zd").show();
                    if( $(this).next().next().val()!=""){
                        var kind_val=$(this).next().next().val().replace(/_/g,',').split(",");
                        $(".form-add-zd ul").html("");
                        for (var i=0; i<kind_val.length;i++) {
                            var str= '<li>'
                                +'<label>字段标题</label>'
                                +'<span><input type="text" name="" id="" value="'+kind_val[i]+'" /></span>'
                                +'<em onclick="$(this).parent().remove()">删除</em>'
                                +'</li>'
                            $(".form-add-zd ul").append(str);
                        }
                    }
                }else{
                    $(".coverDiv").hide();
                    $(this).next().hide();
                    $(".form-add-zd").hide();

                }
            })

            $("#add_zd_check").click(function(){
                var str='<li>'
                    +'<label>字段标题</label>'
                    +'<span><input type="text" name="" id="" value="" /></span>'
                    +'<em onclick="$(this).parent().remove()">删除</em>'
                    +'</li>'
                $(".form-add-zd").find("ul").append(str);
            })




            $("#pop_edit_text_kind").click(function(){
                $("#conf-btn").attr("rowkey","");
                if($(this).prev().val()=="2"){
                    $(".form-add-zd h3").html("单选类型");
                    $(".coverDiv").show();
                    $(".form-add-zd").show().attr("kind","1");
                    var kind_val=$("#pop_edit_text_kind_val").val().replace(/_/g,',').split(",");
                    if(kind_val!=""){
                        $(".form-add-zd ul").html("");
                        for (var i=0; i<kind_val.length;i++) {
                            var str= '<li>'
                                +'<label>字段标题</label>'
                                +'<span><input type="text" name="" id="" value="'+kind_val[i]+'" /></span>'
                                +'<em onclick="$(this).parent().remove()">删除</em>'
                                +'</li>'
                            $(".form-add-zd ul").append(str);
                        }
                    }


                }else if($(this).prev().val()=="3"){
                    $(".form-add-zd h3").html("多选类型");
                    $(".coverDiv").show();
                    $(".form-add-zd").show().attr("kind","1");
                    var kind_val=$("#pop_edit_text_kind_val").val().replace(/_/g,',').split(",");
                    if(kind_val!=""){
                        $(".form-add-zd ul").html("");
                        for (var i=0; i<kind_val.length;i++) {
                            var str= '<li>'
                                +'<label>字段标题</label>'
                                +'<span><input type="text" name="" id="" value="'+kind_val[i]+'" /></span>'
                                +'<em onclick="$(this).parent().remove()">删除</em>'
                                +'</li>'
                            $(".form-add-zd ul").append(str);
                        }
                    }
                }
            })

            $("#textkindselect").click(function(){
                $(".form-add-zd").attr("kind","1");
            });
            $("html").on("click","#display_type_text_list",function(){
                $(".form-add-zd").attr("kind","2");
            });

            $("html").on("click",".item_tips",function(){
                var sss=$(this).parent().parent().attr("rowkey");
                $("#conf-btn").attr("rowkey",sss);
                $(this).next().addClass(sss);
                if($(this).prev().val()=="2"){
                    $(".form-add-zd h3").html("单选类型");
                    $(".coverDiv").show();
                    $(".form-add-zd").show().attr("kind","2");
                    var kind_val=$(this).next().val().replace(/_/g,',').split(",");
                    $(".form-add-zd ul").html("");
                    for (var i=0; i<kind_val.length;i++) {
                        var str= '<li>'
                            +'<label>字段标题</label>'
                            +'<span><input type="text" name="" id="" value="'+kind_val[i]+'" /></span>'
                            +'<em onclick="$(this).parent().remove()">删除</em>'
                            +'</li>'
                        $(".form-add-zd ul").append(str);
                    }

                }else if($(this).prev().val()=="3"){
                    $(".form-add-zd h3").html("多选类型");
                    $(".coverDiv").show();
                    $(".form-add-zd").show().attr("kind","2");
                    var kind_val=$(this).next().val().replace(/_/g,',').split(",");
                    $(".form-add-zd ul").html("");
                    for (var i=0; i<kind_val.length;i++) {
                        var str= '<li>'
                            +'<label>字段标题</label>'
                            +'<span><input type="text" name="" id="" value="'+kind_val[i]+'" /></span>'
                            +'<em onclick="$(this).parent().remove()">删除</em>'
                            +'</li>'
                        $(".form-add-zd ul").append(str);
                    }
                }
            })

            $("select[name=component]").change(function(){
               if($(this).val()=="0"){
                  $(".add_bm_inp").show();
               }else{
                   $(".add_bm_inp").hide();
               }
               if($(this).val()=="1"){
                  $(".add_bm_inp_fs").show();
               }else{
                   $(".add_bm_inp_fs").hide();
               }
            })



        })



        function hideMask(obj){
            var arr=[];
            var count = 0;
            var aa=$(".form-add-zd ul li").find("input");
            $(".form-add-zd ul li").find("input").each(function(){
                var value = $(this).val();
                if (value.length > 0) count++;
            });
            if(count<aa.length){
                layer.msg('所有参数必填，如果不填请删除', {icon: 2,time:2000},function(){
                });
            }else{
                $(".form-add-zd ul li").find("input").each(function(){
                    var value = $(this).val();
                    arr.push(value);
                });
                $(obj).parent().parent().hide();
                $(".coverDiv").hide();

                $(".form-add-zd ul li").find("input").val("");
                if($(".form-add-zd").attr("kind")=="1"){
                    $("#pop_edit_text_kind_val").val(arr.toString().replace(/,/g,'_'));
                    $("#pop_edit_text_kind").show();
                    stri();

                }else if($(".form-add-zd").attr("kind")=="2"){
                    var cla=$("#conf-btn").attr("rowkey");
                    $("."+cla).val(arr.toString().replace(/,/g,'_'));
                    stri();
                }else{
                    $("#pop_edit_text_kind_val").val(arr.toString().replace(/,/g,'_'));
                    $("#pop_edit_text_kind").show();
                    stri();
                };
            }
        }
        function hideMasks(obj){
            $(obj).parent().parent().hide();
            $(".coverDiv").hide();
            stri();
        }

        function stri(){
            var str='<li>'
                +'<label>字段标题</label>'
                +'<span><input type="text" name="" id="" value="" /></span>'
                +'<em onclick="$(this).parent().remove()">删除</em>'
                +'</li>'
                +'<li>'
                +'<label>字段标题</label>'
                +'<span><input type="text" name="" id="" value="" /></span>'
                +'<em onclick="$(this).parent().remove()">删除</em>'
                +'</li>'
                +'<li>'
                +'<label>字段标题</label>'
                +'<span><input type="text" name="" id="" value="" /></span>'
                +'<em onclick="$(this).parent().remove()">删除</em>'
                +'</li>';
            $(".form-add-zd ul").html("");
            $(".form-add-zd ul").append(str);
        }
    </script>
    <script>
        // 上传图片显示
        function uploadImg_vote(file) {
            var ajax_option={
                url:"<?php echo $this->createUrl('/files/upload'); ?>",//默认是form action
                dataType:"json",
                success:function(data){
//                console.log(data);
                    var iv = document.getElementById("imgPreview_vote");
                    var reader = new FileReader();
                    reader.onload = function(evt) {
                        src1 = evt.target.result;
                        iv.src = src1;
                    };
                    reader.readAsDataURL(file.files[0]);
                    if(data.error==0){
                        $("#img").attr("value",data.url);
                    }
                }
            }
            $('#img_vote').ajaxSubmit(ajax_option);
        }
    </script>
    <script type="text/javascript">
        var start = {
            elem: '#start',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            // choose: function(datas){
            //     end.min = datas; //开始日选好后，重置结束日的最小日期
            //     end.start = datas //将结束日的初始值设定为开始日
            //     console.log(datas);
            //     $('input[name="FStartTime"]').trigger("validate");
            // }
        };
        var end = {
            elem: '#end',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
        //     choose: function(datas){
        //          var ts= new Date(document.getElementById("start").value);
        // var ts1=ts.getTime()+86400000;
        // var te= new Date(document.getElementById("end").value);
        // var te1=te.getTime();
        // if(te1<ts1){
        //  document.getElementById("end").value="";
        //   layer.msg("开始和结束时间必须间隔一天");
        // }
        //         start.max = datas; //结束日选好后，重置开始日的最大日期
        //         $('input[name="FEndTime"]').trigger("validate");
        //     }
        };
        laydate(start);
        laydate(end);



        var url          = "<?php echo $this->createUrl('/activity/vote/Add'); ?>";
        $('.save_button').click(function(){
            var id           = $("input[name='id']").val();
            var pid          = $("input[name='pid']").val();
            var component        = $("#component").find('option:selected').val();
            var rule        = $("select[name='rule']").find('option:selected').val();
            var isshow        = $("select[name='isshow']").find('option:selected').val();
            var title        = $("input[name='title']").val();
            var start_time   = $("input[name='start_time']").val();
            var end_time     = $("input[name='end_time']").val();
            var address    = $("input[name='address']").val();
            var phone    = $("input[name='phone']").val();
            var desc         = $("textarea[name='desc']").val();
            var background         = $("textarea[name='background']").val();
            var share_img    = $("input[name='share_img']").val();
            var img    = $("input[name='img']").val();
            var share_desc     = $("input[name='share_desc']").val();
            var hold_votes     = $("input[name='hold_votes']").val();
            var obj=document.getElementsByName('tag');
            var tag='';
            for(var i=0; i<obj.length; i++){
                if(obj[i].checked) tag+=obj[i].value+'_';
            }



            if( $(".add_bm_inp").attr("display")=="block"){
                if(!img || !title || !start_time || !share_img || !share_desc|| ! end_time ||! desc ||! background || !component || !address || !phone    || !rule){
                    layer.msg("所有参数为必填");
                    return false;
                }
            }else{
                if(!img || !title || !start_time || !share_img || !share_desc|| ! end_time ||! desc ||! background || !component || !isshow ){
                    layer.msg("所有参数为必填");
                    return false;
                }
            }

            if(!tag){
                layer.msg("请选择标签");
                return false;
            }

            if(  $(".add_bm_inp").css("display")=="block"){
                if(/^1[34578]\d{9}$/.test(phone)){
                    console.log('正确');
                }else if(!(!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(phone))){
                    console.log('正确');
                }else{
                    layer.msg("手机或电话号码不正确");
                    return false;
                }
            }

            var data = {
                id:id,
                pid:pid,
                component:component,
                title:title,
                start_time:start_time,
                end_time:end_time,
                desc:desc,
                isshow:isshow,
                background:background,
                img:img,
                tag:tag,
                address:address,
                phone:phone,
                share_img:share_img,
                share_desc:share_desc,
                rule:rule,
                hold_vote:hold_votes?hold_votes:0,
            };
            $.post(url,data,function(res){
                var res = JSON.parse(res);
                $('.save_button').attr("disabled","true");
                $('.save_button').text("提交中....");
                if(res.statue==1){
                    layer.msg(res.msg,{time:2000},function(){
                        window.location.href="<?php echo $this->createUrl('/activity/vote/list').'/pid/'.$config['pid'].'/active/3'; ?>";
                    })
                }else{
                $('.save_button').attr("disabled","false");
                $('.save_button').text("保存");
                    layer.msg(res.msg)
                }
            })
        })


        function checkPhone(phone){
            if(!(/^1[34578]\d{9}$/.test(phone))){
                alert("手机号码有误，请重填");
                return false;
            }
        }

    </script>
<?php echo $this->renderpartial('/common/footer', $config); ?>