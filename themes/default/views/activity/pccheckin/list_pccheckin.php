<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">

<div class="components w980 clearfix">
<?php echo $this->renderpartial('/common/assembly',array('active'=>$config['active'],'pid'=>$config['pid']))?>
<div class="center">
<div class="new_wrap">
    <div class="other_333 clearfix">
        <div class="right_222">
            <div class="i_222">组件 <span class="add-activity"><a href="<?php echo $this->createUrl('/activity/pccheckin/add',array('pid'=>$config['pid']))?>">+ 新增活动</a><span></div>
            <div class="content_222">
                <table class="table_222">
                    <thead>
                    <tr>
                        <td>活动ID</td>
                        <td>活动名称</td>
                        <td>开始时间</td>
                        <td>结束时间</td>
                        <td>状态</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($asList):foreach($asList as $val): ?>
                    <tr>    
                        <td><?php echo $val->id;?></td>
                        <td><?php echo $val->title;?></td>
                        <td><?php echo date('Y-m-d H:i:s',$val->start_time);?></td>
                        <td><?php echo date('Y-m-d H:i:s',$val->end_time);?></td>
                        <td><?php $result = Activity_pccheckin::activityStatus($val->start_time,$val->end_time);echo $result['message']?></td>    
                        <td>                           
		                    <a class="icon_1" title="查看" href="javascript:void(0);" onclick="getWinList(<?php echo $val->id?>,'<?php echo $val->title?>')"></a>
                            <a class="<?php if($result['status'] == 0 || $result['status']==-1){echo 'icon_2';}if($result['status'] == 1){echo 'icon_5';}?>" href="javascript:void(0)" title="停止活动" onclick="getStatus('<?php echo $result['message']?>',<?php echo $val->id?>)"></a>
                            <a class="icon_3" title="编辑" href="<?php echo $this->createUrl('/activity/pccheckin/add',array('fid'=>$val->id,'pid'=>$config['pid']))?>"></a>
                            <a class="icon_4" title="删除" href="javascript:void(0);" onclick="delActivity(<?php echo $val->id?>)"></a>
                            <a href="<?php echo $this->createUrl('/activity/pccheckin/view',array('id'=>$val->id))?>" target="_blank">预览</a>
                        
                        </td>
                    
                    </tr>
                    <?php if(!empty($view['wechat_url'])){ ?>
                    <tr>
                      <td colspan="6" >
                      <div style="padding: 20px 10px;border-top: 1px solid #E6E6E6;border-bottom: 1px solid #E6E6E6;">
                        <label style="float: left;">微信自定义链接:</label>
                        <textarea style="width: 74%;line-height: 26px;border: 1px solid #E6E6E6;background: #FFFFFF;"><?php echo $view['wechat_url'].urlencode($this->_siteUrl.$this->createUrl('/activity/pccheckin/view',array('id'=>$val->id)))?></textarea>
                        <a style="float: right;cursor: pointer;" onclick="Copy(this)">点击复制</a>
                        </div>
                         <script>
               function Copy(obj){ 
               var e=$(obj).prev();
               e.select(); 
               document.execCommand("Copy");
               alert("复制成功")  } 
                </script>
                      </td>
                    </tr>
                    <?php 
                      }
                    endforeach;endif;
                    ?>   
                    </tbody>

                </table>
                <div class="page_222">
                    <div class="ep-pages">
                    <?php
                      $this->widget('CoLinkPager', array('pages' => $pagebar,
                      'cssFile' => false,
                      'header'=>'',
                      'firstPageLabel' => '首页', //定义首页按钮的显示文字
                      'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                      'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                      'prevPageLabel' => '前一页',
                       )
                     );
                    ?>                                                                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    
    //ajax 请求获取中奖名单
    function getWinList(id,title){
        //var index = layer.load(2,{shade: [0.3, '#393D49']});
        layer.open({
  		  type: 2,
  		  title:'签到用户列表',
  		  area: ['700px', '500px'],
  		  skin: 'layui-layer-rim', //加上边框
  		  content: ["<?php echo $this->createUrl('/activity/pccheckin/AddList')?>/fid/"+id+"/title/"+title]
  		});
    }
    
    //活动状态提示
    function getStatus(state,fid){
        if(state=='未开始'){
            layer.confirm('活动还未开始？活动的开始时间将被置为当前时间！', {
              btn: ['确定','取消']
            }, function(){
              var url = "<?php echo $this->createUrl('/activity/pccheckin/ActivityPause')?>";
              $.post(url, {fid:fid,type:1}, function (res) { 
                var res = JSON.parse(res);
                layer.msg(res.msg,{time:2000},function(){
                    location.reload();
                })         
              })
            })
        }
        if(state=='进行中'){
        	layer.confirm('活动正在进行中？活动的结束时间将被置为当前时间！', {
                btn: ['确定','取消'] 
              }, function(){
                var url = "<?php echo $this->createUrl('/activity/pccheckin/ActivityPause')?>";
                $.post(url, {fid:fid,type:2}, function (res) { 
                  var res = JSON.parse(res);
                  layer.msg(res.msg,{time:2000},function(){
                      location.reload();
                  })         
                })
              })
        } 
        if(state=='已结束'){
            layer.msg('活动已经结束')
        }    
    }
    
    function delActivity(fid){
        layer.confirm('确认要删除活动吗？', {
          btn: ['确定','取消'] 
        }, function(){
          $.post('<?php echo $this->createUrl('/activity/pccheckin/Delete')?>', { fid: fid }, function (data) { 
      	    var data = JSON.parse(data);
            if(data.errorcode == 0 && data.status=='success'){              
               layer.msg('活动已删除！', {icon: 1,time:2000},function(){
            	   location.reload()
               });
            }
            else if(data.errorcode == 1){
                layer.msg('活动删除失败', {icon: 1});
            }
            else{
                layer.msg('系统错误...', {icon: 1});
            }                  
          });                           
        });return;      
    
    }
 </script>
<?php echo $this->renderpartial('/common/footer', $config); ?>