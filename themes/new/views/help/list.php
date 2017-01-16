<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<style>
.pages{width:100%;text-align:center;height:28px;margin:15px auto;}
.pages ul{height:28px;line-height:28px;padding:0;margin:0 auto;display:inline-block; *display:inline;}
.pages ul li{float:left;margin:0 2px;line-height:28px;height:28px;}
.pages ul li a,.pages ul li span{color:#000;padding:5px 10px;border:1px solid #c8c8c8;border-radius: 3px}
.pages ul li a:hover,.pages ul li a.hover{color:#fff;background:#ccc;font-weight:bold;}
.pages ul li.selected{background:#ccc}
.pages ul li.selected a{font-weight:bold}
</style>

<div class="cjwt_zh w1200 p80">
	<div class="czzy_nav">
    	<ul>
            
      
            <?php  $about_page_arr = JkCms::getList('help',$view['category_id'],'','', '`order` desc,id desc','',1);?>
            <?php  if($about_page_arr){ $i=1;foreach($about_page_arr as $a){?>
            <li <?php  if($i==1){?>class="current"<?php } ?> ><a class=""  href="#pos<?php echo $a['id'];?>" data_url="<?php echo Mod::app()->createUrl('help/'.$a['alias']);?>"><?php echo $a['title'];?></a></li>
            <?php $i++;}} ?>
<!--            <li class="current">
            	<a class="" href="#pos1">如何加入腾讯创业</a>
            </li>
            <li class >
            	<a href="#pos2">如何撰写、展现项目信息</a>
            </li>
            <li class>
            	<a href="#pos3">如何提交项目视频</a>
            </li>
            <li class>
            	<a href="#pos4">哪里能看到我的项目信息</a>
            </li>-->
        </ul>
     </div>
     <div class="czzy_cont">
     	<div>
        	  <p id="pos10">大楚创业是腾讯旗下针对创业领域的媒体开放平台。其最大的特色是，给予创业者主导权，实现用户自主提交项目信息，并将内容包装呈现在亿万用户面前。</p>
              <p>大楚创业有哪些特色与服务，现在来为你一一展现。</p>
              
                <?php  if($about_page_arr){ $i=1;foreach($about_page_arr as $a){?>
                <p id="pos1<?php echo $i-1;?>" class="czzy_p"><i><?php echo $i;?></i><?php echo $a['title']?></p>
                <?php echo $a['content']?>
                <?php $i++;}} ?>
                
<!--              <p class="czzy_p"><i>1</i>如何加入腾讯创业</p>
              <p>首先，访问腾讯创业首页startup.qq.com，用QQ号登陆后，点击“提交你的创业产品”，即可提交你的项目信息。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic1.jpg"></img>
              <p>以上，都是创业者必须填的注册信息。请一定按框外提示的文字来填写。</p>
              <p>那么提交完这份注册信息后，真正展现你项目内涵的程序才刚刚开始。</p>-->
            
<!--              <p id="pos11" class="czzy_p"><i>2</i>给创业者主导权，自主提交创业项目信息</p>
              <p>先回到你最初提交注册信息的页面。如果你提交的注册信息，通过了后台的审核，就可以看到以下这样的页面：</p>
              <img src="{{site_path}}/themes/default/images/zy_pic2.jpg"></img>
              <p>在左侧“内容管理”下的菜单列表，可以快速地进行“提交视频”、“提交新内容”、“素材库”等操作。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic3.jpg"></img>
              <p>在页面右侧，进入到腾讯创业的特色功能——“模块化写作”区域。</p>
              <p>千篇一律的产品PR稿令人生厌，用户最爱看的莫过于简洁、易懂、直白的干货。如何生成这样的写作？且一步步看来——按信息提
示，来填写你项目的基础信息。</p>
			  <img src="{{site_path}}/themes/default/images/zy_pic4.jpg"></img>
              <p>第一排，下拉“行业分类”菜单，选取你项目所处的行业。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic5.jpg"></img>
              <p>第二排，下拉“产品信息”，选取你想填写的内容类型。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic6.jpg"></img>
              <p>第三排，要为你的产品，选取一个好标题，一个好标题好比是哈利波特额头的“N”印记，清晰直白，让人过目不忘。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic7.jpg"></img>
              <p>我们看过诸多创业者为自己的内容拟定这样的标题，如“XX：XXXX的第一平台”，又或“XXX，你理想中的XXX”。创业者们，这样的标题只会让用户当你是推销员而疏远你。你的标题需要说清楚产品核心功能，对用户有什么意义。不如参考以下这些标题：</p>
              <img src="{{site_path}}/themes/default/images/zy_pic8.jpg"></img>
              <p>第四排，你需要给你的产品上传一张传神的图片。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic9.jpg"></img>
              <p>请严格按照尺寸需求上传，否则图片会严重变形。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic10.jpg"></img>
              <p>第五排，用简洁明了的一句话介绍你的产品及意义。</p>
              <p>接下去的几排，都是让创业者从客观角度去阐述项目，比如产品核心功能、产品特色、如何看待竞争对手等维度。切忌过分自吹自擂，否则将被打回重写。</p>
              <p>如果你不想回答这个问题，可以点击每个框右上角的“X”，关掉这个填空题。</p>
              <p>同时，为了让整个页面充满动感，建议创业者配上相应的产品图片，如果是多个竖图，请设计成组合图，方便用户理解。但切记！一定要按提示的尺寸来裁图，否则图片会变形！会变形！会变形！（重要的话说三遍）</p>
              <img src="{{site_path}}/themes/default/images/zy_pic11.jpg"></img>
              <p>最后，如果你还想设置其他的问题，也可以自行设置问题，自行回答（如下图）</p>
              <img src="{{site_path}}/themes/default/images/zy_pic12.jpg"></img>
              <p>点击“保存”，完成内容的提交。</p>
              <p><strong>一个完整的由创业者自主提交的项目信息，如下图：</strong></p>
              <img src="{{site_path}}/themes/default/images/zy_pic13.jpg"></img>
                
              <p id="pos12" class="czzy_p"><i>3</i>如何提交项目视频</p>
              <p>如果已经为项目拍摄VCR的创业者，可以和运营小伙伴取得联系，他们会帮创业完善视频上传信息。在取得联系前，仍需要自主提交视频相关信息。具体步骤如下——</p>
              <p>1.首先在同一个页面的左侧，“内容管理”中点击“提交视频”，显示出右侧的画面。依次选择，然后填写视频标题。</p>
              <img src="{{site_path}}/themes/default/images/zy_pic14.jpg"></img>
              <p>填写下面的问答题，详细化视频中展现的产品信息</p>
              <img src="{{site_path}}/themes/default/images/zy_pic15.jpg"></img>
              <p>填写下面的问答题，详细化视频中展现的产品信息</p>
              <p><strong>一个完整的，上传完视频的页面信息是这样的：</strong></p>
              <img src="{{site_path}}/themes/default/images/zy_pic16.jpg"></img>
              <p><strong>Tips:</strong></p>
              <p>如果还有任何疑问，请参考“腾讯创业”官方微信号（qqchuangye）中“历史信息”推送的《腾讯创业上线了！十个问题解决你的所有疑惑》找答案。</p>
                 
               <p id="pos13" class="czzy_p"><i>4</i>哪里能看到我的项目信息？</p>
               <p>腾讯创业首页重点展示优选项目，平台根据项目的品质与内容做了区分。</p>
               <img src="{{site_path}}/themes/default/images/zy_pic17.jpg"></img>
               <p>在首页头屏区域，可看到重点推荐项目的精彩视频，在右侧“往期精彩”中，还可以看到过往重点推荐项目的视频。只需看几分钟视频，就能迅速了解一个创业产品及团队。</p>
               <p>用户进入视频页面后，可以在页面右侧查看创业项目相关信息。同时在看完视频后，对视频内容进行当机立断的决策——用“点赞或踩”来表达你的好感度。</p>
               <img src="{{site_path}}/themes/default/images/zy_pic18.jpg"></img>
               <p>回到首页后，可以继续下拉页面查看其它项目。</p>
               <img src="{{site_path}}/themes/default/images/zy_pic19.jpg"></img>
               <p>这个区域的右侧，根据用户点赞来排序的、最受好评的创业项目。左侧的“最新产品榜”则会持续推送最新项目。</p>
               <p>页面继续下拉，你可以看到经过后台审核过的所有项目。也可以通过行业分类，查找最新的垂直领域创业项目。</p>
               <img src="{{site_path}}/themes/default/images/zy_pic20.jpg"></img>
               <p>点开页面底部的“更多”，将进入到项目汇总页。</p>
               <p>点击某个项目，可以清晰地看到创业者自主提交的项目信息。</p>
               <img src="{{site_path}}/themes/default/images/zy_pic21.jpg"></img>
               <p>右侧为项目基本信息，下方是产品二维码，可扫码下载使用。</p>
               <p>左侧是创业者对产品的介绍与功能描述，以及对产品定位的解答。（备注：腾讯创业杜绝纯PR稿件，因此每篇创业者提交的内容，都经过严格过滤。</p>
               <img src="{{site_path}}/themes/default/images/zy_pic22.jpg"></img>
               <p>看，有这么多用户点赞，除了项目本身富有创意外，文字内容的编排也是功不可没。在“相关文章”中，还关联了与之类似的创业项目，方便用户阅读。</p>
               <p>除此之外，腾讯创业上的优质项目，将会在腾讯网科技频道、腾讯新闻客户端科技页卡等区域同步推广。未来，还有以下服务，是创业者值得期待的——</p>
               <p><strong>1.深度报道</strong></p>
               <p>根据用户对创业产品的点击热度与好感度，腾讯科技会对创业团队进行深度报道，挖掘产品背后的人与故事。</p>
               <p><strong>2.线下分享会与创业服务对接</strong></p>
               <p>为了更好地建设行业生态圈，腾讯创业定期开办线下创业分享会，邀请业内顶级投资机构、智囊导师与创业者互动。</p>
               <p>还有更多服务，敬请期待。</p>
               <p>马上提交你的项目，加入腾讯创业，让世界发现你！</p>-->
           </div>
     </div>
     <!--czzy_cont end-->
</div>


<?php $this->renderPartial('/common/footer',array('config'=>$config));?>


