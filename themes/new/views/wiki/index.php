<?php echo $this->renderpartial('/common/header_new', $config); ?>
    


<script src="<?php echo $this->_theme_url; ?>assets/js/prism.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
      $(function(){
        $(window).scroll(function(){
          if($(document).scrollTop()>190){
            $(".ad-document1-left").addClass("ad-document1-left-fixed");
          }else{
            $(".ad-document1-left").removeClass("ad-document1-left-fixed");
            
          }
        })
        $(".ad-document1-left ul").click(function(){
            var i=$(this).index();
            $(".ad-document-txt").hide();
            $("#d"+i).show();
            $(".ad-document1-left ul h3").removeClass("selected");
            $(this).find("h3").addClass("selected");  
          })
        $(".ad-document1-left ul h3").click(function(){
          $(".ad-document1-left ul li").removeClass("selected");
        })
        $(".ad-document1-left ul").find("li").click(function(){
          $(".ad-document1-left ul li").removeClass("selected");
          $(this).addClass("selected");
        });
        
      })
      
    </script>

                  

      <div class="ad-app-list w1000 clearfix bxbg mgt30 ad-document">
        
        <div class="clearfix ad-alltit mgb30 mgt30">
            
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-document.png"></i>
                <span>文档资料</span>
            </div>
            
            
            <!-- <div class="fr ad-alltit-right clearfix">
            <div class="ad-document-search clearfix">
              
                <form action="" method="get">
                <input  class="search-inp" type="search" placeholder="搜索问题或关键字" name="" id="" value="" />
                <input class="search-btn" type="submit" value=""/>
            </form>
           
            </div>
              
            </div> -->
               
            
        </div>
      
      <!--tit end-->
      
      
      <div class="ad-document1 clearfix">
        
        <div class="fl ad-document1-left">
          <ul class="selected">
            <h3 class="selected"><a href="#开放平台概要">开放平台概要</a></h3>
          </ul>
          
          
          
          <ul class="selected">
            <h3><a href="#平台使用说明">平台使用说明</a></h3>
            <span>
              <li><a href="#登录和注册">登录和注册</a></li>
              <li><a href="#创建应用">创建应用</a></li>
              <li><a href="#应用管理">应用管理</a></li>
            </span>
          </ul> 
          
           <ul class="selected">
            <h3><a href="#应用管理介绍">应用管理介绍</a></h3>
            <span>
              <li><a href="#查看应用组件数据">查看应用组件数据</a></li>
              <li><a href="#活动组件介绍">活动组件介绍</a></li>
              <li><a href="#应用配置信息">应用配置信息</a></li>
            </span>
          </ul>
          
          <!--<ul>
            <h3>创建活动</h3>
          </ul>
          
          <ul class="selected">
            <h3>SDK接入</h3>
            <span>
              <li><a href="">SDK功能介绍</a></li>
              <li><a href="">SDK使用说明</a></li>
            </span>
          </ul>-->
          
        </div>
        
        <!--left end-->
        
        
        <div class="ad-document1-right">
         
         <div class="ad-document-txt" id="d0" style="display: block;">
          <div class="ad-document-tit">
            <h2 id="开放平台概要">开放平台概要</h2>
            <p class="clearfix">
            <i class="fl">更新时间：2016-09-14 14:45</i>
            <i class="fr">标签：开放平台</i>
            </p>
          </div>
          
          <div class="ad-document-main">
            
          <div class="ad-document-gs">  
            <p>大楚开放平台基于腾讯、大楚、合作方三类产品业务为基础，搭建统一帐号体系，通过各类媒体、民生、商业等业务的联合运营，沉淀各类带有“标签”的用户关系链，围绕“标签”进行深度运营和精准营销。</p>
            
<p>大楚开放平台现具备大楚用户中心及积分商城功能，后期将陆续开放日历、城市服务、一元购、众筹、海报生成等插件给运营人员，同时将开放SDK提供给第三方后续开发。</p>
          <img style="width: 90%;margin: 30px auto;display: block;" src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img1-1.png"/>
          
          </div>
                 
          </div>
          
          
            
          
         </div>
              
              
              
              <div class="ad-document-txt" id="d1" style="display: none;">
          <div class="ad-document-tit">
            <h2 id="平台使用说明">平台使用说明</h2>
            <p class="clearfix">
            <i class="fl">更新时间：2016-09-14 16:02</i>
            <i class="fr">标签：使用说明</i>
            </p>
          </div>
          
          <div class="ad-document-main">
          
          <div class="ad-document-sm">
            <h3 id="登录和注册">登录和注册</h3>
            <p>点击右上角进行登陆/注册</p>
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img1.png"/>
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img2.png"/>
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img3.png"/>
            
            <h3 id="创建应用">创建应用 </h3>
            <p>点击右上角的添加应用，帮助用户创建属于自己的应用。</p>
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img5.png"/>
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img4.png"/>
            
            
            <h3 id="应用管理">应用管理 </h3>
           
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img8.png"/>
            
            
          </div>
 
              </div>
            </div>
            
              
              <div class="ad-document-txt" id="d2" style="display: none;">
          <div class="ad-document-tit">
            <h2 id="应用管理介绍">应用管理介绍</h2>
            <p class="clearfix">
            <i class="fl">更新时间：2016-09-14 17:33</i>
            <i class="fr">标签：应用管理</i>
            </p>
          </div>
          
          <div class="ad-document-main">
          
          <div class="ad-document-sm">
            
            <p style="margin-top: 20px;">点击应用管理中应用产品的详情页，可了解产品的相关数据。
应用管理中会显示应用运行状态，应用数据内含昨日数据与本周数据，同时包含访问数据、用户数据、行为数据、积分数据等</p>
       <h3 id="查看应用组件数据">查看应用组件数据</h3>
          <p>访问数据--访问数据中，通过具象图形和列表的详细的记录了，以时间为节点的用户PV及UV的数据统计分析</p>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img6.png"/>
            <p>新增用户数据--用户数据中，新增用户的数据统计，人数和时间组合的统计表，宏观的分析出平台和用户之间的联系，更好的掌握用户信息和用户数据，以及时间段。</p>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img7.png"/>
            
            <p>行为数据--行为数据中，精准分析用户的浏览行为，呈现出来。</p>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img9.png"/>
            
              <p>积分数据--积分数据中，表格式记录用户的ID，用户名，手机号，和积分状态。</p>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img10.png"/>
            
            
             <h3 id="活动组件介绍">活动组件介绍</h3>
          <p>大楚开放平台将活动组件分为常用四类：娱乐类组件、活动类组件、生活类、服务类</p>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img11.png"/>
          
           <h3 id="应用配置信息">应用配置信息</h3>
          <p>应用信息 接口配置</p>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img12.png"/>
          <img src="<?php echo $this->_theme_url; ?>assets/images/ad-doc-img13.png"/>
          
              </div>
              
            </div>  
          </div>    
              
              
        </div>
        
      
      <!--right end-->
        
      </div>
      

        
      
    </div>

  
  
  





<?php echo $this->renderpartial('/common/footer', $config); ?>