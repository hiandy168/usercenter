<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url ?>style/all.css">
<div class="content index  mgauto w1200">
        <?php $this->renderPartial('/project/project_type_menu');?>
        <hr class="bottom_border w1200 cb mt30 fl">
        <div class="cl"></div>
        <h2 class="wzjh cb"><span>最热项目榜</span></h2>
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
              <li class="fl  <?php if(!$i%3){?>first<?php } ?>">
                <a href="<?php echo Mod::app()->createUrl('project/detail/id/'.$item['id'])?>">
                <div class="item">
                     <?php $banner_img_attachment = JkCms::getAttachmentByid( $item['banner_attachment']); ?>
                    <img alt="" src="<?php echo Tool::show_img($banner_img_attachment['url'])?>">
                    <h4 class="title"><?php echo $item['title']?></h4>
                    <p class="desc"><?php echo $item['description']?></p>
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
                              <?php 
//                            $project_type= JkCms::getproject_typeByid($item['type_id']);
//                            echo $project_type['title'];
                            ?></span></li>
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



function doloading(more) {
    var $more = arguments[0]?true:false;    
  
    var $url = "<?php echo Mod::app()->createUrl('project/ajaxlist/recommend/focus')?>";
     
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


 function insert_html(data,more){
     var $more = arguments[1]?true:false; 
     
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
        alert('1231');
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