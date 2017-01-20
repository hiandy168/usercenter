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
        <!-- <div class="ad-app-list-tit">
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
            <div class="ad-edit-app-nav">
                <ul>
                    <li class="selected">
                        <a href="">编辑活动</a>
                    </li>
                 <!--   <li class="">
                        <a href="">实时预览</a>
                    </li>-->
                    <li class="">
                        <a href="">开发者示例</a>
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
                                <div class="t_title">活动详情</div>
                                <div class="form-inp">
                                    <textarea style="resize-y:none;width:100%;height:150px;border:1px solid #CDCDCD;"  name='desc' rows="3" cols="20" placeholder="活动详情" class="input_text"><?php echo isset($activity_info['desc']) ? $activity_info['desc'] : ''; ?></textarea>
                                    <div class="del"></div>
                                </div>

                                <!-- 上传图片1 start -->
                                <div class="t_title"><i style="color: red">*</i>签到背景图片(图片大小：640*280)</div>
                                <div class="form-inp">
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
                                <!-- 上传图片 end -->
                                <button class="save_button adbtn linear" style="width: 30%;margin: 30px 0px;">保存</button>
                            </div>
                        </div>
                    </div>
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
                                $redirect   =   'http://m.dachuw.net/activity/pccheckin/view/id/<?php echo $_GET['fid'] ?>';
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
            </div>
        </div>
    </div>

<!-- 组件 end -->


    <script>
        function upload() {
            document.getElementById("upimg1").click();
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
    //      end.min = datas; //开始日选好后，重置结束日的最小日期
    //      end.start = datas //将结束日的初始值设定为开始日
    //      console.log(datas);
    //      $('input[name="FStartTime"]').trigger("validate");
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
    //     var ts= new Date(document.getElementById("start").value);
    //     var ts1=ts.getTime()+86400000;
    //     var te= new Date(document.getElementById("end").value);
    //     var te1=te.getTime();
    //     if(te1<ts1){
    //      document.getElementById("end").value="";
    //       layer.msg("开始和结束时间必须间隔一天");
    //     }
    //     start.max = datas; //结束日选好后，重置开始日的最大日期
    //     $('input[name="FEndTime"]').trigger("validate");
    // }
};
laydate(start);
laydate(end);


var url          = "<?php echo $this->createUrl('/activity/pccheckin/add'); ?>";
$('.save_button').click(function(){

	var id           = $("input[name='id']").val();
	var pid          = $("input[name='pid']").val();
	var title        = $("input[name='title']").val();
	var start_time   = $("input[name='start_time']").val();
	var end_time     = $("input[name='end_time']").val();
	var desc         = $("textarea[name='desc']").val();
	var share_img    = $("input[name='share_img']").val();
	var img    = $("input[name='img']").val();
    var share_desc     = $("input[name='share_desc']").val();
    var obj=document.getElementsByName('tag');
    var tag='';
    for(var i=0; i<obj.length; i++){
        if(obj[i].checked) tag+=obj[i].value+'_';
    }
    if(!title||!start_time||!desc||!end_time||!img){
        layer.msg("所有参数为必填");
        return false;
    }
    if(!tag){
        layer.msg("请选择标签");
        return false;
    }
	var data = {
			id:id,
			pid:pid,
			title:title,
			start_time:start_time,
			end_time:end_time,
			desc:desc,
            share_img:share_img,
            tag:tag,
            img:img,
            share_desc:share_desc
    };
	$.post(url,data,function(res){
		var res = JSON.parse(res);
         $('.save_button').attr("disabled","true");
         $('.save_button').text("保存中...");
		if(res.statue==1){
		    layer.msg(res.msg,{time:2000},function(){
		        window.location.href="<?php echo $this->createUrl('/activity/pccheckin/list').'/pid/'.$config['pid'].'/active/3'; ?>";
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