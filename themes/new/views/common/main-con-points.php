<div class="ad-data-con w1000 clearfix bxbg mgt30">
        
    <div class="clearfix ad-alltit mgb30 mgt30">
            
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-data4.png"/></i>
                <span>用户积分数据</span>
            </div>
            
            
            <div class="fr ad-alltit-right clearfix">
                
                <!--选择分类跳转-->

                   <div class="ad-newkind fr">
                   <div class="ad-newkind1">
                    <span><?php echo $view->name; ?></span>
                    <i></i>
                   </div>
                   <div class="ad-newkind2 bxbg">
                    <ul>
                        <?php if(!empty($project_list)){?>
                    <?php foreach($project_list as $project){?>
                    <?php if($view->id ==$project->id ){continue;}?>
                        <li>
                        <a style="" href="<?php echo $this->createAbsoluteUrl('/project/appmgt',array('id'=>$project->id)); ?>" style='color: #177c77;'><?php echo $project->name?></a>
                        </li>
                    <?php } ?>
                    <?php }?>
                    </ul>
                   </div>
                   </div>
                
                <div class="ad-alltit-rightnav fr">
                    <a href="javascript:window.history.go(-1);" class="a1" title="返回上一级"></a>
                    <!-- <a href="" class="a2" title="添加应用"></a> -->
                </div>

                <div class="fr clearfix">
                  <form action="" method="post">
                           <input style=" line-height: 14px;border: 1px solid #dedede;padding: 10px;border-radius: 4px;border-right: none;margin-right: -2px;background: none; outline: none;" name="username" placeholder="搜索用户名或手机" value="<?php echo isset($point['username'])?'':$point['username'];?>">
                           <input style="float: right;width: 50px;" class="schbtn linear adbtn" type="submit" name="" id="" value="查询" />
                       </form>
                </div>
 
            </div>
            
            
            
        </div>
       
        
      
      <!--tit end-->
      
      
      <div class="ad-data-map">
        
        
        
        
        <div class="ad-data-jf-table">
          <table class="bxbg"  border="0" cellspacing="0" cellpadding="0">
              <tr class="t1">
                <td>ID</td><td>用户名 </td><td>手机号</td><td>积分</td>
              </tr>
                    <?php foreach ($point['user'] as $val){?>
                        <tr>
                            <td><?php echo $val['id']?></td>
                            <td><?php echo $val['username']?></td>
                            <td><?php echo $val['phone']?></td>
                            <td><?php echo $val['point']?></td>
                        </tr>
                     <?php }?>
          </table>
          
        </div>
        
        
        <!--list end-->
        <div class="ad-page-list mgt30 mgb30">
              <?php
                $this->widget('CoLinkPager', array('pages' => $point['pagebar'],
                'cssFile' => false,
                'header'=>'',
                'footer'=>'共 '.$point['count'].' 条数据',
                'firstPageLabel' => '首页', //定义首页按钮的显示文字
                'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                'prevPageLabel' => '前一页',
                 'maxButtonCount'=>5
                 )
               );
              ?>    
        </div>
      
      </div>
      
      
      
    </div>