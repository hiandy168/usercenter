<?php echo $this->renderpartial('/common/header_new',$config); ?>


<!--组件目录-->
<?php echo $this->renderpartial('/common/assembly',array('active'=>$config['active'],'pid'=>$config['pid']))?>
<script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url;?>assets/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>

<script>
    var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";

</script>
<!--act nav-->
  <div class="ad-act-list  bxbg ">
    <!--     <div class="ad-app-list-tit">
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
        <div class="ad-edit-app-navsd ">
             <ul>
                     <li  class="selected" >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/scratchcard/add',array('id'=>$activity_info['id']))?>">编辑刮刮卡</a>
                        <?php }else if($config['pid']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/add',array('pid'=>$config['pid']))?>">添加大转盘</a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/scratchcard/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">奖品/概率</a>
                         <?php } ?>
                    </li>
                    <li class="">
                         <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/scratchcard/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">开发者示例</a>
                         <?php } ?>

                    </li>
                    
                </ul>
       
        </div>
        <!--nav end-->
        <div class="ad-edit-app-con">
            <div class="ad-edit-app-1 ad-edit-app-condiv  clearfix" style="display: block">
                <div class="ad-edit-app-1formbg fl">
                    <form id="img_form" method="POST" enctype="multipart/form-data" >
                    <img id="imgPreview" src="<?php if($activity_info['share_img']) {echo JkCms::show_img($activity_info['share_img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                    <i>上传图像
                        <input class="fileinput" type="file" onchange="uploadImg(this)"  name="imgFile" id="upimg" value="<?php echo $activity_info['share_img']?>" /></i>
                        <input type="hidden" name="share_img" id="share_img" value="<?php echo $activity_info['share_img']?>">
                    <p>该图像是用于微信分享时使用建议上传大小为300*300</p>
                    </form>
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

                            <div class="t_title">活动开始时间<span>请填写活动开始时间</span></div>
                            <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['start_time']) ? date('Y-m-d H:i:s', $activity_info['start_time']) : ''; ?>" placeholder="请填写活动开始时间" class="form-control" name="start_time" id="start" /></span>

                            </div>
                            <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                            <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['end_time']) ? date('Y-m-d H:i:s', $activity_info['end_time']) : ''; ?>" placeholder="请填写活动结束时间" class="form-control" name="end_time" id="end" /></span>

                            </div>
                            <div class="t_title">用户可中奖次数<span>（请填写整数）</span></div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['win_num']) ? $activity_info['win_num'] : ''; ?>" placeholder="用户可中奖次数" class="form-control" name="win_num" />
                                  </span>
                            </div>
                            <div class="t_title">每人每天抽奖次数</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['day_count']) ? $activity_info['day_count'] : ''; ?>" name='day_count' placeholder="每天每天可以抽奖的次数" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">中奖提示</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['win_msg']) ? $activity_info['win_msg'] : ''; ?>" name='win_msg' placeholder="中奖提示" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">活动规则</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['rule']) ? $activity_info['rule'] : ''; ?>" name='rule' placeholder="活动规则" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">领奖方式</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['lingjiang']) ? $activity_info['lingjiang'] : ''; ?>" name='lingjiang' placeholder="领奖方式" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">次数结束提示</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['end_num_msg']) ? $activity_info['end_num_msg'] : ''; ?>" name='end_num_msg' placeholder="次数结束提示" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">活动结束提示</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['end_msg']) ? $activity_info['end_msg'] : ''; ?>" name='end_msg' placeholder="活动结束提示" class="form-control" />
                                  </span>
                            </div>
                            <?php
                            if($prize){
                                foreach ($prize as $val){
                                    ?>
                                    <input type="hidden" value="<?php echo $val['id']?>" name="p_id[]">
                                    <div class="t_title">自定义名称</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['title']?>" placeholder="" class="form-control" name="p_title[]" />
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品名称</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['name']?>" placeholder="" class="form-control"  name="p_name[]" />
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品数量</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['count']?>" placeholder="" class="form-control" name="p_num[]"/>
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品剩余数量</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['remainder']?>" placeholder="" class="form-control" name="p_snum[]"/>
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品概率<span>(填入整数)</span></div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['probability']?>" placeholder="" class="form-control" name="p_v[]"/>
                                        <div class="del"></div>
                                    </div>
                                    <?php
                                }
                            }else{
                                ?>
                                <div class="input upload_pic clearfix">
                                    <div class="adbtn linear" style=" width: 23%;line-height: 36px;text-align: center;margin-top: 20px;" id="continue_ad_20160422" >添加奖项</div>
                                </div>
                            <?php } ?>
                            <div class="t_title">概率基数<span>(奖品概率5,概率基数100000,则中奖概率十万分之五)</span></div>
                            <div class="form-inp">
                                      <span>
                                       <?php if($activity_info['id'] && $activity_info['id']){ ?>
                                          <input type="text" value="<?php echo isset($activity_info['jishu']) ? $activity_info['jishu'] : '100000'; ?>" name='jishu' placeholder="概率基数(填入整数)" class="form-control"  disabled="disabled"/>
                                     <?php }else{ ?>
                                        <input type="text" value="<?php echo isset($activity_info['jishu']) ? $activity_info['jishu'] : '100000'; ?>" name='jishu' placeholder="概率基数(填入整数)" class="form-control" />
                                     <?php } ?>
                                       
                                 
                                  </span>
                            </div>
                            <!-- 上传图片1 start -->
                            <div class="t_title"><i style="color: red">*</i>刮刮乐banner图片(图片大小：640*280)</div>
                            <div class="form-inp">
                                <form id="img_scratch" method="POST" enctype="multipart/form-data" >
                                    <img id="imgPreview_vote" width="120px" height="100px"  onclick="upload('upimg1')" src="<?php if($activity_info['banner_img']) {echo JkCms::show_img($activity_info['banner_img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                                    <input class="fileinput" style="display: none" type="file" onchange="uploadImg(this,'img','imgPreview_vote','img_scratch')"  name="imgFile" id="upimg1" value="" />
                                </form>
                                <input type="hidden" name="banner_img" id="img" value="<?php echo $activity_info['banner_img']?>">
                            </div>

                            <!-- 上传图片1 start -->
                            <div class="t_title"><i style="color: red">*</i>刮刮乐背景图片(最佳尺寸：750*740)</div>
                            <div class="form-inp">
                                <form id="from_bg_img" method="POST" enctype="multipart/form-data" >
                                    <img id="img_bg_img" width="120px" height="100px" onclick="upload('up_bg_img')" src="<?php if($activity_info['bg_img']) {echo JkCms::show_img($activity_info['bg_img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                                    <input class="fileinput" style="display: none" type="file" onchange="uploadImg(this,'bg_img','img_bg_img','from_bg_img')"  name="imgFile" id="up_bg_img" value="" />
                                </form>
                                <input type="hidden" name="bg_img" id="bg_img" value="<?php echo $activity_info['bg_img']?>">
                            </div>

                            <!-- 上传图片1 start -->
                            <div class="t_title"><i style="color: red">*</i>中奖纪录(最佳尺寸：656*672)</div>
                            <div class="form-inp">
                                <form id="from_myprize_img" method="POST" enctype="multipart/form-data" >
                                    <img id="img_myprize_img" width="120px" height="100px" onclick="upload('up_myprize_img')" src="<?php if($activity_info['myprize_img']) {echo JkCms::show_img($activity_info['myprize_img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                                    <input class="fileinput" style="display: none" type="file" onchange="uploadImg(this,'myprize_img','img_myprize_img','from_myprize_img')"  name="imgFile" id="up_myprize_img" value="" />
                                </form>
                                <input type="hidden" name="myprize_img" id="myprize_img" value="<?php echo $activity_info['myprize_img']?>">
                            </div>

                            <div class="t_title">分享描述</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['share_desc']) ? $activity_info['share_desc'] : ''; ?>" name='share_desc' placeholder="分享描述" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">分享地址<span>（如果不填默认为当前活动地址）</span></div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text" value="<?php echo isset($activity_info['share_url']) ? $activity_info['share_url'] : ''; ?>" name='share_url' placeholder="分享地址，请加上 http://" class="form-control" />
                                  </span>
                            </div>
                            <div class="t_title">微信分享开启关闭<span>（用于活动是否可以分享到朋友圈等）</span></div>
                            <div class="add-tags">
                                <label for="ss">
                                    <input type="radio" id="ss" name="share_switch" value="1" <?php echo $activity_info['share_switch']==1?'checked="checked"':""; ?>>
                                    <i>开启</i>
                                </label>
                                <label for="sss">
                                    <input type="radio" id="sss" name="share_switch" value="2" <?php echo $activity_info['share_switch']==0?'checked="checked"':""; ?>>
                                    <i>关闭</i>
                                </label>
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
                   
                            
                    <div class=" linear" style="width: 50%;margin-bottom: 10px;margin-left: 50px;color:#ff0000" disable="disable">
                        活动进行中不能编辑，请先暂停活动！
                    </div>
                    <?php if($activity_info['id'] &&  $activity_info['status']==1 ){?>
                    <button class="adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;background:#ff0000" id='p_button'  onclick="activitystatus()">
                        暂停
                    </button>
                     <button class="save_button adbtn linear"  id='save_button' style="width: 30%;margin-bottom: 40px;margin-left: 50px;display:none">
                        保存
                     </button>
                     <?php }else{ ?>
                     <button class="save_button adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;">
                        保存
                     </button>
                     <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</div>

<script>
    function upload(id) {
        document.getElementById(id).click();
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
        // choose: function(datas){
        //      var ts= new Date(document.getElementById("start").value);
        // var ts1=ts.getTime()+86400000;
        // var te= new Date(document.getElementById("end").value);
        // var te1=te.getTime();
        // if(te1<ts1){
        //  document.getElementById("end").value="";
        //   layer.msg("开始和结束时间必须间隔一天");
        // }
        //     start.max = datas; //结束日选好后，重置开始日的最大日期
        //     $('input[name="FEndTime"]').trigger("validate");
        // }
    };
    laydate(start);
    laydate(end);



    $("#continue_ad_20160422").on('click', function () {

        var temp_html = '<div class="t_title">自定义名称</div>'+
            '<div class="form-inp">'+
            '<input type="text" value="" placeholder="" class="form-control" name="p_title[]" />'+

            '</div>'+
            '<div class="t_title">奖品名称</div>'+
            '<div class="form-inp">'+
            '<input type="text" value="" placeholder="" class="form-control"  name="p_name[]" />'+

            '</div>'+
            '<div class="t_title">奖品数量</div>'+
            '<div class="form-inp">'+
            '<input type="text" value="" placeholder="" class="form-control" name="p_num[]"/>'+

            '</div>'+
            '<div class="t_title">奖品剩余数量</div>'+
            '<div class="form-inp">'+
            '<input type="text" value="" placeholder="" class="form-control" name="p_snum[]"/>'+


            '</div>'+
            '<div class="t_title">奖品概率<span>(请填入整数，例如5，概率是以下面的概率基数为分母，填入数值为分子，默认概率基数为100000，中奖概率为10万分之5)</span></div>'+
            '<div class="form-inp">'+
            '<input type="text" value="" placeholder="" class="form-control" name="p_v[]"/>'+

            '</div>';
        var parent = $(this).parents(".upload_pic");
        $(temp_html).insertBefore(parent);
    });
    var url          = "/activity/scratchcard/add";
    
    
     function activitystatus(){
           //询问框
            layer.confirm('确定暂停活动么？', {
              btn: ['确定','取消'] //按钮
            }, function(){
                        var id = $("input[name='id']").val();
                        //为真表示编辑，活动进行的时候不能编辑
                        if(id){
                            $.ajax({
                            type: "POST",
                            url: "<?php echo $this->createUrl('/activity/scratchcard/activitystatus'); ?>",
                            data:{ "id": id,'type':2},
                            dataType:'json',
                            success: function(res){
                                   layer.msg(res.msg);
                                   if(res.state==1){
                                       $('#save_button').show();
                                       $('#p_button').css({"disabled":"disabled","background":"#cccccc"});
                                   }
                                   return false;
                            }
                        });
                        }
            }, function(){

            });  
       }
       
       
    $('.save_button').click(function(){

        var id = $("input[name='id']").val();
        //为真表示编辑，活动进行的时候不能编辑
        if(id){
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('/activity/scratchcard/is_status'); ?>",
                data:{
                    "id": id,
                },
                success: function(msg){
                    if(msg==2){
                        layer.msg("活动进行中，避免数据错误，暂时不能编辑");
                        return false;
                    }else if(msg==3){
                        layer.msg("非法提交");
                        return false;
                    }

                }
            });
        }
        


        var pid          = $("input[name='pid']").val();
        var title        = $("input[name='title']").val();
        var start_time   = $("input[name='start_time']").val();
        var end_time     = $("input[name='end_time']").val();
        var win_num      = $("input[name='win_num']").val();
        var day_count    = $("input[name='day_count']").val();
        var share_num    = $("input[name='share_num']").val();
        var share_add_num= $("input[name='share_add_num']").val();
        var win_msg      = $("input[name='win_msg']").val();
        var rule         = $("input[name='rule']").val();
        var lingjiang    = $("input[name='lingjiang']").val();
        var end_num_msg  = $("input[name='end_num_msg']").val();
        var end_msg      = $("input[name='end_msg']").val();
        var jishu        = $("input[name='jishu']").val();
        var share_img    = $("input[name='share_img']").val();
        var img    = $("input[name='img']").val();
        var banner_img   = $("input[name='banner_img']").val();
        var bg_img       = $("input[name='bg_img']").val();
        var scratch_img  = $("input[name='scratch_img']").val();
        var myprize_img     = $("input[name='myprize_img']").val();
        var obj_p_title      = $("input[name='p_title[]']");
        var share_desc     = $("input[name='share_desc']").val();
        var share_url     = $("input[name='share_url']").val();

        var obj=document.getElementsByName('share_switch');
        var share_switch='';
        for(var i=0; i<obj.length; i++){
            if(obj[i].checked) share_switch+=obj[i].value;
        }


        var obj=document.getElementsByName('tag');
        var tag='';
        for(var i=0; i<obj.length; i++){
            if(obj[i].checked) tag+=obj[i].value+'_';
        }

        if(!title|| !start_time|| !end_time|| !win_num|| !day_count||  !win_msg|| !rule|| !lingjiang|| !end_num_msg|| ! end_msg|| !jishu  || !obj_p_title){
            layer.msg("所有参数为必填");
            return false;
        }

        if(!tag){
            layer.msg("请选择标签");
            return false;
        }


        var p_title=new Array();
        var checkes=false;
        obj_p_title.each(function(index,item){
            if(!$(this).val()){
                 checkes=true;
            }
            p_title[index]=$(this).val();
        });
        var obj_p_name     = $("input[name='p_name[]']");
        var p_name=new Array();
        obj_p_name.each(function(index,item){
            if(!$(this).val()){
                checkes=true;
            }
            p_name[index]=$(this).val();
        });
        var obj_p_num      = $("input[name='p_num[]']");
        var p_num=new Array();
        obj_p_num.each(function(index,item){
            if(!$(this).val()){
                checkes=true;
            }
            p_num[index]=$(this).val();
        });

        /*奖品剩余数量*/
        var obj_p_snum = $("input[name='p_snum[]']");
        var num = $("input[name='p_snum[]']");
        var p_snum = new Array();
        obj_p_snum.each(function (index, item) {
            var snumber=$(num[index]).val();//剩余奖品数据
            var number=$(this).val();//奖品数据量
            if (!number || number<=snumber && snumber<0) {
                checkes = true;
            }
            p_snum[index] = $(this).val();
        });

        var obj_p_v      = $("input[name='p_v[]']");
        var p_v=new Array();
        var p_v_all=0;
        obj_p_v.each(function(index,item){
            if(!$(this).val()){
                checkes=true;
            }
            p_v_all+=parseInt($(this).val());
            p_v[index]=$(this).val();
        });
        var obj_p_id      = $("input[name='p_id[]']");
        var p_id=new Array();
        obj_p_id.each(function(index,item){
            if(!$(this).val()){
                checkes=true;
            }
            p_id[index]=$(this).val();
        });

        if(p_v_all>jishu){
            layer.msg("请注意,概率基数应小于或等于奖品概率总和");
            return false;
        }
        if(!p_title.length || checkes ){
            layer.msg("请添加奖项");
            return false;
        }
        var data = {
            id:id,
            pid:pid,
            title:title,
            start_time:start_time,
            end_time:end_time,
            win_num:win_num,
            day_count:day_count,
            share_num:share_num,
            share_add_num:share_add_num,
            win_msg:win_msg,
            rule:rule,
            lingjiang:lingjiang,
            end_num_msg:end_num_msg,
            end_msg:end_msg,
            jishu:jishu,
            share_img:share_img,
            img:img,
            share_desc:share_desc,
            share_url:share_url,
            banner_img:banner_img,
            bg_img:bg_img,
            scratch_img:scratch_img,
            share_switch:share_switch,
            myprize_img:myprize_img,
            p_title:p_title,
            p_name:p_name,
            tag:tag,
            p_num:p_num,
            p_snum:p_snum,
            p_v:p_v,
            p_id:p_id
        };
        $.post(url,data,function(res){
            var res = JSON.parse(res);
             $('.save_button').attr("disabled","true");
             $('.save_button').text("提交中....");
            if(res.state==1){
                layer.msg(res.msg,{time:2000},function(){
                        
                        if(res.aid &&  res.aid!='undefined'){
                            window.location.href = "<?php echo $this->createUrl('/activity/scratchcard/prize')?>"+'?id='+res.aid;
                        }else{
                           window.location.href = "<?php echo $this->createUrl('/activity/scratchcard/list') . '/pid/' . $config['pid'] . '/active/1'; ?>"; 
                        }
                })
                
                
            }else{
                $('.save_button').attr("disabled","false");
                $('.save_button').text("保存");
                layer.msg(res.msg)
            }
        })
    })




</script>

<?php echo $this->renderpartial('/common/footer', $config); ?>

