<?php echo $this->renderpartial('/common/header_new', $config); ?>
    <div class="ad-app-list w1000 clearfix bxbg mgt30">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>文档中心</h3>
            </div>

        </div>
        <!--tit end-->


        <div class="ad-faq-tips">
            快速接入和使用，让开发更便捷。
        </div>


     <div class="ad-doc-arc">
       
       <div class="ad-doc-arctop">
       
                    <h1><?php echo $list->title?></h1>
                    
                    <ul>
                        
                    <li>
                    <h4>作者:</h4>
                    <p><?php echo $list->auther?></p>/
                    <h4>来源:</h4>
                    <p><?php echo $list->copyfrom?></p>/
                    <h4>发表时间:</h4>
                    <p><?php echo date('Y-m-d H:i',$list->createtime)?></p>
                    
                </li>
                        
                    </ul>
                    
        </div>
        
            <div class="ad-doc-arcdesc">
            文章描述：<?php echo $list->description?>
        </div>
        
        
        <div class="ad-doc-arccon">
            
           <?php echo $list->content?>
        </div>
        
        
        
        <div class="ad-doc-arctips"><span>标签：</span>
            <em><?php echo $tags->title?></em>
        </div>
        
        
       </div>
  
  
  



     






    </div>




<!--list end-->




</div>

<?php echo $this->renderpartial('/common/footer', $config); ?>