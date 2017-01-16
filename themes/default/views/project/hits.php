<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url ?>style/all.css">
<div class="content index  mgauto w1200">
    <div class="three_w" avalonctrl="articleList">
        <div class="move_nav w1200 fl">
            <div class="title tc fl"><a href="javascript:void(0)" name="-1" class="industry_class fall">全部</a></div>
            <div class="con fr">
                <a class="left_btn" href="#"></a>
                <div class="con_wt">
                    <ul id="typelist">
                        <li class="cy"><a href="javascript:void(0)" name="1" class="industry_class">餐饮</a></li>
                        <li class="jz"><a href="javascript:void(0)" name="2" class="industry_class">家政</a></li>
                        <li class="my"><a href="javascript:void(0)" name="3" class="industry_class">美业</a></li>
                        <li class="qc"><a href="javascript:void(0)" name="4" class="industry_class">汽车</a></li>
                        <li class="ly"><a href="javascript:void(0)" name="5" class="industry_class">旅游</a></li>
                        <li class="yl"><a href="javascript:void(0)" name="6" class="industry_class">医疗</a></li>
                        <li class="jr"><a href="javascript:void(0)" name="7" class="industry_class">金融</a></li>
                        <li class="yj"><a href="javascript:void(0)" name="8" class="industry_class">硬件</a></li>
                        <li class="sj"><a href="javascript:void(0)" name="9" class="industry_class">社交</a></li>
                        <li class="fc"><a href="javascript:void(0)" name="10" class="industry_class">房产</a></li>
                        <li class="jy"><a href="javascript:void(0)" name="11" class="industry_class">教育</a></li>
                        <li class="cx"><a href="javascript:void(0)" name="12" class="industry_class">出行</a></li>
                        <li class="ds"><a href="javascript:void(0)" name="13" class="industry_class">电商</a></li>
                        <li class="yx"><a href="javascript:void(0)" name="14" class="industry_class">游戏</a></li>
                        <li class="dt"><a href="javascript:void(0)" name="15" class="industry_class">电台</a></li>
                        <li class="yd"><a href="javascript:void(0)" name="16" class="industry_class">阅读</a></li>
                        <li class="yy"><a href="javascript:void(0)" name="17" class="industry_class">音乐</a></li>
                        <li class="zx"><a href="javascript:void(0)" name="18" class="industry_class">资讯</a></li>
                        <li class="aq"><a href="javascript:void(0)" name="19" class="industry_class">安全</a></li>
                        <!--<li class="qt"><a href="javascript:void(0)" name="0" class="industry_class">其他</a></li>-->
                    </ul>
                </div>
                <a class="right_btn" href="#"></a>
            </div>
        </div>
        <hr class="bottom_border w1200 cb mt30 fl">
        <div class="cl"></div>
        <h2 class="wzjh cb"><span>往期精彩</span></h2>
        <div class="num-show">
            <em></em>
            <span class="t1">共搜索到<i id="count"><?php echo $count?></i>条结果</span>
        </div>
        
         <div class="w1200 loading" style="text-align:center;padding:20px 0">
           <img src="<?php echo $this->_theme_url ?>images/loading.gif">
        </div>
     
        <div class="projectlist cl" >
              <ul class="ar-project-list3 clearfix" id="projectlist"  style="display:none;" data-page='1'  data-type='0'>
           
     <?php  if($list){$i=0;foreach($list as $item){?>
              <li class="fl  //<?php if(!$i%3){?>first<?php } ?>">
                <a href="//<?php echo Mod::app()->createUrl('project/detail/id/'.$item['id'])?>">
                <div class="item">
                     //<?php $banner_img_attachment = JkCms::getAttachmentByid( $item['banner_attachment']); ?>
                    <img alt="" src="//<?php echo Tool::show_img($banner_img_attachment['url'])?>">
                    <h4 class="title">//<?php echo $item['title']?></h4>
                    <p class="desc">//<?php echo $item['description']?></p>
                    <div class="action">
                    <?php
                    if(!$item['good'] && !$item['bad']){
                    $good_percent ='50%';
                    }else{
                     $good_percent = round($item['good']/($item['good']+$item['bad'])*100);
                     $good_percent = $good_percent.'%';
                    }
                    ?>
                        <div class="ratio">好评率：<?php echo $good_percent?></div>
                        <ul class="infos clearfix">
                            <li style="width:45%;"><span class="property">行业：</span><span class="value"> 
                                //<?php 
//                            $project_type= JkCms::getproject_typeByid($item['type_id']);
//                            echo $project_type['title'];
//                            ?></span></li>
                            <!--<li style="width:55%;"><span class="property">团队规模：</span><span class="value">11-50人</span></li>-->
                            <li style="width:100%;"><span class="property">融资进度：</span><span class="value">//<?php echo $item['finance']?></span></li>
<!--                            <li style="width:55%;"><span class="property">总融资额：</span><span class="value">{{el.FTotalFinancingAmount}}</span></li>-->
                        </ul>
                    </div>
                </div>
                    </a>
            </li>
            
     <?php $i++; } }?>
       

        </div>
        <div class="more tc fl cb mt15" id="loadingmore">
            <a href="javascript:void(0);" title="1" onclick="loadingmore()">更多 &gt;&gt;</a>
            <img src="<?php echo $this->_theme_url ?>images/loading.gif" style="display:none">
        </div>
    </div>

</div>
<script>
var $page =1;
var $type =0;

$("#typelist li").each(function (i) {
      $(this).click(function(){
       $type = $(this).find('a').attr('name');
       $page = 1;
       doloading();   
      })
});

function loadingmore(){
    $('#loadingmore').find('a').hide();
    $('#loadingmore').find('img').show();
    doloading(1);
}



function doloading($more=false) {
    var $url = "<?php echo Mod::app()->createUrl('project/ajaxlist/order/hits')?>";
     
//    alert(newpage);
            $.ajax({
                type: 'post',
                url: $url+'?'+ Math.random(),
                data:{page:$page,type:$type},
                dataType: 'json',
                success: function (data) {
                        if (data.state == 1){//成功
                           if($more){
                                    $('#loadingmore').find('a').show();
                                    $('#loadingmore').find('img').hide();
                            }else{
                                $('.loading').hide();
                            }
                            $('#projectlist').show();
                            insert_html(data.list,$more);
                            $('#count').html(data.count);
                              $page = parseInt($page)+1;
                        }else if(data.state == 0){//失败
                      
                        }
                }
            });
}     


 function insert_html(data,more=false){
     var iidex = 1;
     var  $html='';
     for(var o in data){  
         var temp_class= '';
         if(!iidex%3){ temp_class='first';}
              $html +="<li class='fl "+temp_class+"'>";
              $html +="      <a href='"+data[o].url+"'>";
              $html +="       <div class='item'>";
              $html +="        <img alt='' src='"+data[o].banner+"'>";
              $html +="          <h4 class='title'>"+data[o].title+"</h4>";
              $html +="        <p class='desc'>"+data[o].description+"</p>";
              $html +="        <div class='action'>";
              $html +="            <div class='ratio'>好评率："+data[o].good_percent+"</div>";
              $html +="           <ul class='infos clearfix'>";
              $html +="              <li><span class='property'>行业：</span><span class='value'>"+data[o].type_name+"</span></li>";
              $html +="           <li><span class='property'>团队规模：</span><span class='value'>11-50人</span></li>";
              $html +="              <li style='width:100%;'><span class='property'>融资进度：</span><span class='value'>"+data[o].finance+"</span></li>";
              $html +="         </ul>";
              $html +="     </div>";
              $html +="  </div>";
              $html +="      </a>";
              $html +=" </li>";
        iidex = parseInt(iidex)+1;
      }  
      
      if(more){
       $($html).appendTo($('#projectlist'));
      }else{
          $('#projectlist').html($html);
      }
 }
 
$(function () {

    doloading();

    $(".left_btn").click(function(){
        if(!$(".move_nav .con_wt ul").is(":animated")){
            if($(".move_nav .con_wt ul").css("marginLeft")!="-770px"){
                $(".move_nav .con_wt ul").animate({marginLeft:"+=-70px"},300)
            }else{
                $(".move_nav .con_wt ul").animate({marginLeft:"0px"},300)
            }
        }
        return false
    })
    $(".right_btn").click(function(){
        if(!$(".move_nav .con_wt ul").is(":animated")) {
            if ($(".move_nav .con_wt ul").css("marginLeft") != "0px") {
                $(".move_nav .con_wt ul").stop(true, true).animate({marginLeft: "+=70px"}, 300)
            }else{

                $(".move_nav .con_wt ul").animate({marginLeft:"-770px"},300)
            }
        }
        return false
    })
    $(".industry_class").click(function(){
        $(".industry_class").removeClass("active");
        $(this).addClass("active");
    })
    //注册

})
</script>
<?php $this->renderPartial('/common/footer',array('config'=>$config));?>