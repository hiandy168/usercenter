
<header id="header">

<div class="children-menu">
	<div class="container">
		<div class="app-name" id="appname" data-toggle="dropmenu" data-event="hover" data-timing="100" data-target=".app-list">
			<p><?php echo $view->name?></p>
			
				<i class="fa icon-angle-down"></i>
			

			<ul style="display: none;" class="app-list">
				<?php if(!empty($project_list)){?>

				<?php foreach($project_list as $project){?>
                                <?php if($view->id ==$project->id ){continue;}?>
                                    <a style="" href="<?php echo $this->createAbsoluteUrl('/project/appmgt',array('id'=>$project->id)); ?>" style='color: #177c77;'><?php echo $project->name?></a>
                                <?php } ?>
					<?php }?>
					<a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>" style='color: #177c77;'>创建应用 <i class="icon-plus" style='font-weight:normal'></i></a>
				
			</ul>
		</div>
            <script>
                $('#appname').hover(function(){
                     $(this).find('ul').show();
                },function(){
                     $(this).find('ul').hide();
                }); 
                    
            </script>
            

		<nav id='project_header_nav'>
			<a class="<?php echo $config['active_1']=='1' ? 'active' : ''?>" href="<?php echo $this->createAbsoluteUrl('/project/appmgt',array('id'=>$config['pid'])); ?>">应用首页</a>
			<a class="<?php echo $config['active_1']=='2' ? 'active' : ''?>" href="<?php echo $this->createAbsoluteUrl('/project/appinfo',array('id'=>$config['pid'])); ?>">基础配置</a>
			<a class="<?php echo $config['active_1']=='3' ? 'active' : ''?>" href="<?php echo $this->createAbsoluteUrl('/activity/Scratchcard/list',array('pid'=>$config['pid'])); ?>">活动组件</a> 
                        <!--<a class="" href="">用户中心界面</a>--> 
<!--			<a class="duiba-depto " href="DevRepo/showDuibaActivity/13877">待选库<span class="new-item">(402)</span></a>-->
		</nav>
<!--		<div class="shortcut">
			<a class="" href="Dorder/orderRecord/13877">我的订单</a> 
			<a class="" href="dorder/ordersAudit/13877">待审核订单</a> 
			<a class="" href="appDataReport/index/13877">数据统计</a>
		</div>-->
	</div>
</div>

<style>.test-tip{width:980px;margin:0 auto;margin-top:20px;}</style>
<div class="remind remind-error test-tip">
<?php
	if($config['active_1'] == 3){
?>
	<table class="table table-bordered">
		<tr>
			<th colspan=2 >接口示例</th>
		</tr>
	    <tr>
	        <td>请求方式</td>
	        <td>get</td>
	    </tr>
	    <tr>
	        <td>URL</td>
	        <td>http://m.hb.qq.com/activity/SignUp/index/id/$id?openid=".$openid</td>
	    </tr>
	    <tr>
	        <td>传入参数</td>
	        <td> openid ： 微信用户的openid
	        </td>
	    </tr>
	    <tr>
	        <td colspan=2 ><a href="/demo/activity_demo.rar" >demo下载</a></td>
	    </tr>
	</table>
<?php
	}else{
		echo "开发测试阶段。";
	}
?>
</div>



</header>