<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<!--cobntent-->
<div class="content member w1200 mgauto mt50">
	    <?php $this->renderPartial('/member/left',array('config'=>$config));?>
    <!--member_nav end-->
    <div id="loadDiv" class="fr" style="width:860px;" >
    <style>.pl108{padding-left: 108px;}</style>
    <div class="member_con pb50">
    
   		<form id="">
        	<label class="form-con">
                <h3 class="fl w100"><b>*</b> 行业分类</h3>
                <select class="fl" name="industry_type">
                	<option selected="" value="">--请选择行业--</option>
                    <option value="0">餐饮</option>
                    <option value="0">家政</option>
                    <option value="0">美业</option>
                    <option value="0">汽车</option>
                    <option value="0">旅游</option>
                    <option value="0">医疗</option>
                    <option value="0">金融</option>
                    <option value="0">硬件</option>
                    <option value="0">社交</option>
                    <option value="0">房产</option>
                    <option value="0">教育</option>
                    <option value="0">出行</option>
                    <option value="0">电商</option>
                    <option value="0">游戏</option>
                    <option value="0">电台</option>
                    <option value="0">阅读</option>
                    <option value="0">音乐</option>
                    <option value="0">资讯</option>
                    <option value="0">安全</option>
                    <option value="0">云计算</option>
                    <option value="0">其他</option>
                </select>
             </label>
            <div class="cl"></div>
            <label class="form-con ">
            	 <h3 class="fl w100"><b>*</b>标题</h3>
                 <input class="fl" type="text" name="title_id"></input>
            </label>
            <div class="cl"></div>
            <label class="form-con ">
            	 <h3 class="fl w100">关键字</h3>
                 <input class="fl" type="text" name="keyword_id" placeholder="3~5个字符"></input>
            </label>
            <div class="cl"></div>
             <label class="form-con " style="position:relative;">
            	 <h3 class="fl w100"><b>*</b>上传图片</h3>
                 <a href="" class="fl btn hui_btn" style="position:relative; z-index:1">上传图片
                 <input  type="file" name="img" value="上传图片" multiple="multiple" />
                 </a>
                  <span class="fl commom btm">宽度小于700像素，宽度要大于高度  (双击删除图片)</span>
            </label>
            <div class="cl"></div>
              <label class="form-con " style="position:relative;">
            	 <h3 class="fl w100"><b>*</b>简介</h3>
                 <textarea class="fl" name="content" style=" width:700px;" placeholder="50-300字之间,可简单描述自己所涉及的领域、产品功能等">
                  </textarea>
             </label>
            <div class="cl"></div>
            <label class="form-con cb need-cpxx " style="padding-left: 108px; position: relative;">
            	<h4 class="tl"><b>*</b><span>产品名称是什么</span></h4>
                <textarea class="fl" placeholder="800字之内" name="question_0_0"> </textarea>
                <a href=""  class="a-upload">
                <input id="browse_01" class="fl btn hui_btn" style="position:relative; z-index:1"type="file" name="img"  multiple="multiple" />
                </a>
              </label>
            <div class="cl"></div>
            <div class="J_items1110 oh-1110 ml124-1110">
            	<label class="lcc-item-1110 current-1110" value="5" name="fenye">行业/市场篇</label>
                <label class="lcc-item-1110 " value="6" name="fenye">产品场篇</label>
                <label class="lcc-item-1110 " value="7" name="fenye">用户篇</label>
                <label class="lcc-item-1110 " value="8" name="fenye">团队篇</label>
                <label class="lcc-item-1110 " value="9" name="fenye">融资/商业模式篇</label>
            </div>
            <div style="border:1px solid #CFCDCE; margin-right: 10px; margin-left: 124px;">
            	<div class="cpxx hide-show oh-1110">
                	<label class="form-con  " style="position:relative">
                    	<h4 class="tl">
                        	<span>你所创业的领域，目前的现状是什么样？存在哪些问题？</span>
                            <a class="fr content_delete_tig" href="">X</a>
                        </h4>
                        <textarea class="w520-1110" placeholder="800字之内"></textarea>
                         <a href=""  class="a-upload">
                		<input id="browse_01" class="fl btn hui_btn" style="position:relative; z-index:1"type="file" name="img"  multiple="multiple" />
                		</a>
                   </label>
                   <div class="cl"></div>
                   <label class="form-con  " style="position:relative">
                    	<h4 class="tl">
                        	<span>该领域前景如何？市场规模有多大？有哪些主要的玩家？</span>
                            <a class="fr content_delete_tig" href="">X</a>
                        </h4>
                        <textarea class="w520-1110" placeholder="800字之内"></textarea>
                         <a href=""  class="a-upload">
                		<input id="browse_01" class="fl btn hui_btn" style="position:relative; z-index:1"type="file" name="img"  multiple="multiple" />
                		</a>
                   </label>
                   <div class="cl"></div>
                   <label class="form-con  " style="position:relative">
                    	<h4 class="tl">
                        	<span>该领域面临的机会与挑战是什么？</span>
                            <a class="fr content_delete_tig" href="">X</a>
                        </h4>
                        <textarea class="w520-1110" placeholder="800字之内"></textarea>
                         <a href=""  class="a-upload">
                		<input id="browse_01" class="fl btn hui_btn" style="position:relative; z-index:1"type="file" name="img"  multiple="multiple" />
                		</a>
                   </label>
                   <div class="cl"></div>
                </div>
            </div>
            <label class="form-con  add_question_div">
            	<span style="color:#f00; font-size:16px;">继续添加你想回答的多个问题或小标题</span>
                <a class="add_question_input" style="background: orange;color: #fff;padding:2px 5px; border-radius: 5px;">添加</a><br><br>
                <div>
                	<div class="delete_for_content" style="position: relative;">
                    	<h4 class="tl">Q：标题
                        	<a class="fr content_delete">X</a>
                        </h4>
                        <div class="cl"></div>
                        <input class="new_question" type="text" placeholder="添加你的问题答案或补充内容"></input><br><br>
                        <h4 class="tl">A：答案</h4>
                        <textarea class="w520-1110" placeholder="添加你的问题答案或补充内容"></textarea>
                         <a href=""  class="a-upload">
                		<input id="browse_01" class="fl btn hui_btn" style="position:relative; z-index:1"type="file" name="img"  multiple="multiple" />
                		</a>
                    </div>
                </div>
            </label>
            <div class="cl"></div>
          </form>
          
          <p class="member_submit fl">
          	<button id="submit_btn" class=" submit_btn btn blue_btn">保存</button>
          </p>
          <div class="cl"></div>
	</div>
    </div>
    </div>
</div>
<?php $this->renderPartial('/common/footer',array('config'=>$config));?>