<?php $this->renderPartial('/common/header',array('config'=>$config));?>

<div class="cjwt_zh1 w1200 p80">
    <?php if(isset($list)&&$list){ foreach($list as $item){?>
	<div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                <?php echo $item['description']?>
            </li>
            <li class="aws_zh">
            	<i></i>
                  <?php echo $item['content']?>
            </li>
        </ul>
      </div>
    <?php } } ?>
<!--      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                为什么让我填写用户名，而不提交密码？
            </li>
            <li class="aws_zh">
            	<i></i>
               腾讯创业直接支持QQ登录。<br>
               <img src="<?php echo $this->_theme_url ?>images/qa_pic1.jpg"></img>
               <p>在这里我们也提供了绑定QQ的选项，建议您使用公司的公共QQ，一旦通过我们的审核，直接通过该QQ就可以继续登录腾讯创业平台。</p>
       
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                所属公司到底是什么意思？
            </li>
            <li class="aws_zh">
            	<i></i>
              产品≠公司，一个产品必定要有所属的公司，公司名是要在工商局等公家行政部门登记的名称。比如，滴滴打车的所属公司就是北京小桔科技有限公司。
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                如何确定我的注册信息已经通过审核？
            </li>
            <li class="aws_zh">
            	<i></i>
              当我们审核完您的注册信息后，会给您发送这样一条短信：“您好，您注册的创业公司，已经通过腾讯创业平台的审核，现在可以打开腾讯创业进行登录。
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                审核通过后，我们如何在腾讯创业上提交内容？
            </li>
            <li class="aws_zh">
            	<i></i>
              共分一下四个步骤：
              <div class="pass_zh">
              	<p class="num1_zh">
                	<i >1</i>
                    <span>点击"http://startup.qq.com"，进入到腾讯创业首页，点击右上角的登录按钮或者头图上的”
  “提交你的创业产品“按钮：</span><br>
  					<img src="<?php echo $this->_theme_url ?>images/qa_pic2.jpg"></img>
  			   </p>
               <p  class="num1_zh">
                	<i >2</i>
                    <span>点击"http://startup.qq.com"，进入到腾讯创业首页，点击右上角的然后输入自己注册时绑定的QQ和QQ密码；如果你正在登录这个QQ，就可以实现快速登录了。</span><br>
  					<img src="<?php echo $this->_theme_url ?>images/qa_pic3.jpg"></img>
  			   </p>
               <p  class="num1_zh">
               	<i >3</i>
                    <span>登录之后，你会发现还是回到了注册页面，这里我们允许创业者重新提交自己的基本信息。</span><br>
  					<img src="<?php echo $this->_theme_url ?>images/qa_pic4.jpg"></img>
  			   </p>
               <p  class="num1_zh">
               	<i>4</i>
                    <span>如果你觉得注册信息没有必要修改，你可以点击左侧的”提交视频“、”提交新内容“等。</span><br>
  		      </p>
             </div>
          
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                为什么会有内容分类这个选项？
            </li>
            <li class="aws_zh">
            	<i></i>
              通过调查，创业者对外展示的信息主要分为产品介绍、融资动态、商业规划、感悟体会等类型，因此我们设定了模块化的问题，专业针对以上类型设定了模块化问题，不同的类型回答不同的问题。
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
                有些问题我不想回答，有些问题你们没问我，或者我不想回答问题，就想用小标题来写，该怎么办？
            </li>
            <li class="aws_zh">
            	<i></i>
               当你有问题不想回答的时候，可以点击这里的”×“<br>
               <img src="<?php echo $this->_theme_url ?>images/qa_pic5.jpg"></img>
               <p>当你觉得有问题我们没问到是，可以点击这行红字：</p>
               <img src="<?php echo $this->_theme_url ?>images/qa_pic6.jpg"></img>
       
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
               我已经有视频链接了，还需要给你们发送视频源文件吗？
            </li>
            <li class="aws_zh">
            	<i></i>
               如果您的视频链接不是腾讯视频，需要给我们发送源文件；如果您的视频链接是腾讯视频，则直接给我们提供的邮箱发送链接即可。
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
               担心视频时间不够用，用户或投资人无法理解我们说的东西？
            </li>
            <li class="aws_zh">
            	<i></i>
              在提交视频这里，我们提供了文字自定义功能，用以对视频进行辅助性说明。<br>
              <img src="<?php echo $this->_theme_url ?>images/qa_pic7.jpg"></img>
       
            </li>
        </ul>
      </div>
      <div class="cjwtDiv_zh">
    	<ul>
        	<li class="que_zh">
            	<i></i>
               素材库是干什么用的？
            </li>
            <li class="aws_zh">
            	<i></i>
               当你提交视频或新内容后，在你自己的素材库里会有相应的显示，你可以进行修改，甚至于撤回。但是一旦通过我们的审核后，提交的内容就无法修改了，只能联系我们进行修改。
            </li>
        </ul>
      </div>-->
    
    <!--cjwt_zh end-->
</div>


    <?php $this->renderPartial('/common/footer',array('config'=>$config));?>

