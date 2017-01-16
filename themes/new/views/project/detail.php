<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<div class="wz_content mgauto w1200 clearfix">
    	<div class="wz_content_l fl mt30">
        	<div class="det_title">
            	<h1><?php echo $view['title']?></h1>
                <p class="pt15">
                	<span class="time sun"><?php echo date('Y-m-d H:i:s',$view['createtime']);?></span>
                	<span class="biaoqian sun ml5">
                            <?php 
                            $project_type= JkCms::getproject_typeByid($view['type_id']);
                            echo $project_type['title'];
                                    ?>
                        </span>
                </p>
            </div>
            <div class="pic_con pt15">
            	<div class="lcc-video-hidden" id="mod_tenvideo_flash_player_1438429064978">
                    
                       <?php $banner_img_attachment = JkCms::getAttachmentByid($view['banner_attachment']); ?>
                       <img id="form_banner_img"  src="<?php echo Tool::show_img($banner_img_attachment['url'])?>" style="margin:auto;max-height:450px;max-width:780px">
                        
<!--                	<embed width="782px" height="530px" align="middle" src="http://static.video.qq.com/TPout.swf?vid=m00199livde&amp;auto=0" quality="high" name="tenvideo_flash_player_1438429064978" bgcolor="#000000" allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" ppluginspage="http://get.adobe.com/cn/flashplayer/" id="tenvideo_flash_player_1438429064978">-->
                    
                </div>
            </div>
            <div class="text_con pt30">
            	<div class="zhengwen">
                    <h3 class="lcc-sub-title">产品描述 </h3>
                    <pre style="word-wrap: break-word; font-family: 微软雅黑; color: rgb(112, 112, 112); font-size: 16px; line-height:30px; white-space: pre-wrap;" class="lcc-grey-bottom article-conent"><?php echo $view['zzrq']; ?>
                    </pre>
                    
                	<h3 class="lcc-sub-title">产品的目标用户群体是谁？有哪些特征？打算如何获取早期用户？ </h3>
                    <pre style="word-wrap: break-word; font-family: 微软雅黑; color: rgb(112, 112, 112); font-size: 16px; line-height:30px; white-space: pre-wrap;" class="lcc-grey-bottom article-conent"><?php echo $view['zzrq']; ?>
                    </pre>
                    <h3 class="lcc-sub-title">当前用户的痛点是什么？如何解决目前的用户痛点?</h3>
                    <pre style="word-wrap: break-word; font-family: 微软雅黑; color: rgb(112, 112, 112); font-size: 16px; line-height:30px; white-space: pre-wrap;" class="lcc-grey-bottom article-conent"><?php echo $view['yhtd']; ?>
                    </pre>
                    <h3 class="lcc-sub-title">你的产品/服务定位是什么？你的产品/服务的最大特点或者核心要素是什么？你的产品/服务行业问题？</h3>
                    <pre style="word-wrap: break-word; font-family: 微软雅黑; color: rgb(112, 112, 112); font-size: 16px; line-height:30px; white-space: pre-wrap;" class="lcc-grey-bottom article-conent"><?php echo $view['cpgn']; ?>
                    </pre>
                    <h3 class="lcc-sub-title">未来的产品规划是什么？</h3>
                    <pre style="word-wrap: break-word; font-family: 微软雅黑; color: rgb(112, 112, 112); font-size: 16px; line-height:30px; white-space: pre-wrap;" class="lcc-grey-bottom article-conent"><?php echo $view['wlgh']; ?>
                    </pre>
                    <h3 class="lcc-sub-title">你所创业的领域，目前的现状是什么样？存在哪些问题？该领域前景如何？市场规模有多大？有哪些主要的用户？</h3>
                    <pre style="word-wrap: break-word; font-family: 微软雅黑; color: rgb(112, 112, 112); font-size: 16px; line-height:30px; white-space: pre-wrap;" class="lcc-grey-bottom article-conent"><?php echo $view['scfx']; ?>
                    </pre>
                </div>
                
                
                <style>
                    
.ar-video-fav {
    margin-bottom: 65px;
    margin-top: 65px;
    width: 100%;
}
.ar-video-fav {
    margin-bottom: 65px;
    margin-top: 65px;
    width: 100%;
}
.ar-video-fav .action {
    margin: 0 auto;
    width: 300px;
}
.ar-video-fav .radio {
    box-sizing: border-box;
    margin: 28px auto 0;
    width: 440px;
}

.ar-video-fav .action .fav {
    background-color: #f17a72;
}
.ar-video-fav .action .block {
    border-radius: 4px;
    box-sizing: border-box;
    color: #fff;
    height: 78px;
    padding: 0 4px;
    width: 104px;
}
.ar-video-fav .action .fav {
    background-color: #f17a72;
}
.ar-video-fav .action .block {
    border-radius: 4px;
    box-sizing: border-box;
    color: #fff;
    height: 78px;
    padding: 0 4px;
    width: 104px;
}

.ar-video-fav .action .nofav {
    background-color: #8baad0;
}
.ar-video-fav .action .block {
    border-radius: 4px;
    box-sizing: border-box;
    color: #fff;
    height: 78px;
    padding: 0 4px;
    width: 104px;
}
.ar-video-fav .action .nofav {
    background-color: #8baad0;
}
.ar-video-fav .action .block {
    border-radius: 4px;
    box-sizing: border-box;
    color: #fff;
    height: 78px;
    padding: 0 4px;
    width: 104px;
}

.ar-video-fav .action .counter {
    border-bottom: 1px dashed #fff;
    font-size: 19px;
    height: 50%;
    line-height: 39px;
    text-align: center;
}

.ar-video-fav .action .action-name img {
    height: 20px;
}
.ar-video-fav .action .action-name {
    cursor: pointer;
    font-size: 19px;
    line-height: 39px;
    text-align: center;
}
.ar-video-fav .radio .percent {
    color: #707070;
    text-align: center;
    width: 50px;
}
.ar-video-fav .radio .radio-bar {
    border-radius: 4px;
    float: left;
    width: 340px;
}
.ar-video-fav .radio .radio-bar .good {
    background-color: #f17a72;
    border-radius: 4px 0 0 4px;
    border-right: 2px solid #fff;
    box-sizing: border-box;
    height: 24px;
}
.ar-video-fav .radio .radio-bar .bad {
    background-color: #8baad0;
    border-radius: 0 4px 4px 0;
    height: 24px;
}
</style>
                <div class="ar-video-fav">
                <div class="action clearfix">
                    <div class="fav block fl">
                                                <div id="upCount" class="counter"><?php echo $view['good']?></div>
                        <div class="action-name" id="do_good">
                            <img src="<?php echo $this->_theme_url ?>images/good.png">&nbsp;<span>顶</span>
                        </div>
                    </div>
                    <div class="nofav block fr">
                        <div id="downCount" class="counter"><?php echo $view['bad']?></div>
                        <div class="action-name" id="do_bad">
                            <img src="<?php echo $this->_theme_url ?>images/bad.png">&nbsp;<span>踩</span>
                        </div>
                    </div>
                </div>
                <div class="radio clearfix">
                    <?php
                    if(!$view['good'] && !$view['bad']){
                    $good_percent = $bad_percent = '50%';
                    }else{
            
                     $good_percent = round($view['good']/($view['good']+$view['bad'])*100);
                     $bad_percent = 100-$good_percent;
                     $good_percent = $good_percent.'%';
                     $bad_percent = $bad_percent.'%';
                    }
                    ?>
                    <div id="downCent" class="percent fr"><?php echo $bad_percent;?></div>
                    <div id="upCent" class="percent fl"><?php echo $good_percent;?></div>
                    <div class="radio-bar clearfix">
                        <div style="width:<?php echo $good_percent;?>;display:" class="good fl" id="uppercent"></div>
                        <div style="width:<?php echo $bad_percent;?>;display:" class="bad fr" id="downpercent"></div>
                    </div>
                </div>
            </div>
                
  <script>
var $id = "<?php echo $view['id']?>";
function dozhan($val) {
    var $url = "<?php echo Mod::app()->createUrl('project/ajaxdozhan')?>";
            $.ajax({
                type: 'post',
                url: $url+'?'+ Math.random(),
                data:{id:$id,value:$val},
                dataType: 'json',
                success: function (data) {
                      $('#upCount').html(data.project.good);
                      $('#downCount').html(data.project.bad);
                      $('#uppercent').css('width',data.good_percent);
                      $('#downpercent').css('width',data.bad_percent);
                       ship_mess_big('提交成功！');
//                        if (data.state == 1){//成功
//                           if($more){
//                                    $('#loadingmore').find('a').show();
//                                    $('#loadingmore').find('img').hide();
//                            }else{
//                                $('.loading').hide();
//                            }
//                            $('#projectlist').show();
//                            insert_html(data.list,$more);
//                            $('#count').html(data.count);
//                              $page = parseInt($page)+1;
//                        }else if(data.state == 0){//失败
//                      
//                        }
                }
            });
}   

function Percentage(number1, number2) { 
    return (Math.round(num / total * 10000) / 100.00 + "%");// 小数点后两位百分比
}


$(function () {


    $("#do_good").click(function(){
       dozhan(1);
    })
    $("#do_bad").click(function(){
       dozhan(2);
    })
    

     var id = "<?php echo $view['id'];?>" ;
     var model = 'project';
     $.ajax({
            type: "post",
            url: "<?php echo  $this->createUrl('/ajax/hitadd')?>",
            data:{id:id,model:model},
            dataType:'json'
        });

    

})
</script>              
                <div class="shenming">
                	<p>声明：</p>
                    <p>大楚创业平台所展示的项目内容均为创业团队自主提交，涉及产品信息、融资金额、产品运营数据等，大楚创业均不对其真实性负责。</p>
                </div>
             </div>
            
             <?php $recommend_project_arr = JkCms::getProjects($view['type_id'], 'recommend', 1, '', 3, 1);?>
            <?php if(!empty($recommend_project_arr)){?>
             <div class="more_text">
             	<div class="tit_1 cb">
                	<h2 class="wzjh ">推荐项目</h2>
                 </div>
             
                 <div class="con_1 cb pt30 oh">
                    <?php $i=0;foreach($recommend_project_arr as $p){?>
                    <div class="pic_model fl <?php  if(!$i){?>first<?php } ?>">
                   		<div class="pic">
                                    <a  target="_blank" href="<?php echo $p['url']?>" class="videoBtn"></a>
                                <a  target="_blank" href="<?php echo $p['url']?>"><img src="<?php echo Tool::show_img($p['banner_img_attachment']['url']);?>" class="tuisong"></a>
                        </div>
                        <div class="tit_2 tc">
                        	<a   target="_blank" href="<?php echo $p['url']?>"><?php echo $p['title']?></a>
                        </div>
                    </div>
                     <?php $i++;} ?>
        
                 	<div class="cl"></div>
                 </div>
             
             </div>
            <?php } ?>
            
            
            <div id="comment" style=" width:100%;"></div>
              
        </div>
        
        <div class="wz_content_r fr mt30">
        	<div>
            	<h3>
                	<span class="fl mr10-c">创业者头像</span>
                    <hr>
                    </h3>
                    <div class="ar-headimg">
              
                        <img style="margin: auto" src="<?php echo JkCms::show_member_thumb($view['member']['picture']) ?>" >
                    </div>
             </div>
             <div>
            	<h3>
                	<span class="fl mr10-c">所属公司</span>
                    <hr>
                </h3>
                <h4 class="mt15 lcc-grey-bottom"><?php echo $view['member']['company_name'] ?></h4>
             </div>
             <div class="pt30">
             	<h3>
                	<span class="fl mr10-c">团队组成</span>
                    <hr>
                </h3>
                  <?php $company_leaders = unserialize($view['company_leaders']);?>
                    <?php
//                    var_dump($company_leaders);die;
                       $leaders_count = count($company_leaders['name']);
                       if($leaders_count){
                           for($i=0;$i<$leaders_count;$i++){
                                echo  '<h4 class="mt15 ">'.$company_leaders['name'][$i].'</h4>';
                                echo '<p class="lcc-grey-bottom">'.$company_leaders['position'][$i].'</p>';
                           }
                       }
         
                    ?>

             </div>
             <div class="pt30">
             	<h3>
                	<span class="fl mr10-c">融资进度</span>
                    <hr>
                </h3>
                <h4 class="mt15 "><?php echo $view['finance'] ?></h4>
              </div>
              <div class="pt30">
             	<h3>
                	<span class="fl mr10-c"> 融资金额 </span>
                    <hr>
                </h3>
                <h4 class="mt15 "><?php echo $view['money'] ?></h4>
              </div>
              <div class="pt30">
             	<h3>
                	<span class="fl mr10-c">  产品地址  </span>
                    <hr>
                </h3>
                  <?php echo $view['app_address'] ?>
                <!--<img width="170" src="<?php echo $this->_theme_url ?>images/cp-1.jpg" style="margin-left: 116px; margin-top: 30px;" class="cb tc fl">-->
                <a target="_blank" href="<?php echo Mod::app()->createAbsoluteUrl('project/release') ?>" style="margin-left: 130px; margin-top: 50px;" class="btn blue_btn fl cb">提交你的产品</a>
              </div>
          </div>
  
     <div class="cl"></div>
      <!--wz_list-->
     </div>
  

<script>
 var targetid    = '<?php echo $view['targetid']?>';
function getComment(){
	if(targetid)
	$('#comment').html('<iframe src="http://www.qq.com/coral/coralCommentDome.htm" width="100%" height="300px" frameborder="no" scrolling="no" id="commentIframe"></iframe>');
}
</script>
     
<?php $this->renderPartial('/common/footer',array('config'=>$config));?>